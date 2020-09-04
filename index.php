<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instagram2.0</title>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>
<header>
    <img class="logo-head" src="./images/logo.png">
    <div class="head-about">
        <p>Телефон: такой-то</p></br>
        <p>E-mail: <span style="text-decoration: underline;">такой-то</span></p></br>
    </div>
    <p style="font-size:50px;margin-top:10px; margin-left:15%;">Комментарии </p>
</header>
<body>
<div>
    <div id='vueapp'  class="main">
    <div class="comment" v-for='(com,index) in coms'>
</br> <div class="name"><span class="name_text" > {{ com.name }}</span></div> <span style="position:relative;margin-left:5%">{{ com.time }}</span>
        <span style="position:relative;margin-left:20px"> {{ com.year }} </span></br>
        <span class="com_text">{{com.comment}}</span></br>
        <input type='button' value='Delete' @click='deleteRecord(com.id)'>
    </div>
    </br>
    <div class="divider"></div>
    <form class="add">
        <p style="font-size:30px;">Оставить комментарий</p></br>
        <label>Ваше имя</label> </br>
        <input type="text" name="name" v-model="name">
         </br>
        <label>Ваш комментарий</label></br>
        <textarea class="text-comment" type="text" name="comment" v-model="comment"></textarea>
        </br>
        <input class="button-add" type="submit" name="submit" @click="createCom()" value="Отправить">
    </form>
    </div>
</div>
</body>
<footer>
    <img class="logo-foot" src="./images/logo.png">
    <div class="about">
        <p>Телефон: такой-то</p>
        <p>Адрес: <span style="text-decoration: underline;">такой-то</span></p>
        <p>Почта: <span style="text-decoration: underline;">такой-то</span></p></br>
        <p>2010-2020 Future все права защищены</p>
    </div>
</footer>
</html> 
<style>
    .divider{
  position: absolute;
height: 1px;
left: 6%;
right: 0px;
width: 90%;
opacity: 0.3;
background: #000000;
}
.name{
    width:10%;
    display:inline-block;
}
.about{
    position: relative;
    top:-110px;
    left:30%;
    width:30%;
    line-height: 1px;
    font-weight:bold;
}
.head-about{
    font-weight:bold;
    line-height: 1px;
    margin-top:-150px;
    margin-left:15%;
}
.com_text{
    overflow-x:hidden;
    max-width:80%;
    width:auto;
    margin-top:20px;
}
.name_text{
    font-size:20px;
    font-weight:bold;
}
.logo-foot{
    margin-left:15%;
    margin-top:25px;
    height:100px;
    width:100px;
}
.logo-head{
    margin-left:75%;
    margin-top:15px;
    height:170px;
    width:170px;
}
header{
    background-color:#f7f0f0;
    height:200px;
}
footer{
    background-color:#f7f0f0;
    height:150px;
}
.add{
    line-height: 21px;
    height:auto;
    position:relative;
    margin-left:15%;
}
.comment{
    max-width:80%;
    width:auto;
    line-height: 21px;
    position:relative;
    margin-left:15%;
}
label{
    width:40%;
}
.text-comment{
    resize: none;
    border: 1.5px solid black;
    height:100px;
    width:39%;
}
.button-add{
    width:10%;
    margin-left:30%;
    border: 1.5px solid black;
}
input {
    border: 2px solid white;
  width: 40%;
  padding: 2px 5px;
  margin: 2px 0;
  box-sizing: border-box;
}

input[type=button]{
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 4px 7px;
  text-decoration: none;
  margin: 2px 1px;
  cursor: pointer;
}
tr:hover {background-color: #f5f5f5;}
.main{
    height:auto;
    width:100%;
    background-color:#f0e6e6;
}
</style>
<script language="javascript">
var app = new Vue({
  el: '#vueapp',
  data: {
      name: '',
      comment: '',
      time:'',
      coms: []
  },
  mounted: function () {
    console.log('Hello from Vue!')
    this.getCom()
  },

  methods: {
    getCom: function(){
        axios.get('api/comments.php')
        .then(function (response) {
            console.log(response.data);
            app.coms = response.data;
            length=app.coms.length
            for(i=0;i<length;i++)
            {
                first=response.data[i].time.split(' ')
                days=first[1].split(':')
                second=first[0].split('-')
                app.coms[i].time=''+days[0]+':'+days[1] 
                app.coms[i].year=second[2]+'.'+ second[1]+'.'+ second[0]
                console.log(app.coms.length)
            }
        })
        
        .catch(function (error) {
            console.log(error);
        });
    },
    createCom: function(){
        console.log("Create contact!")
        let formData = new FormData();
        var d= new Date();
        var time=(d.getFullYear()+"-"+d.getMonth()+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds())
        var control = document.getElementById("your-files");
        formData.append('name', this.name)
        formData.append('comment', this.comment)
        formData.append( 'time',time)
        var comment = {};
        formData.forEach(function(value, key){
            comment[key] = value;
        });
        axios({
            method: 'post',
            url: 'api/comments.php',
            data: formData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
            console.log(response)
            app.coms.push(comment)
            app.resetForm();app.img();
        })
        .catch(function (response) {
            console.log(response)
        });
    },
    resetForm: function(){
        this.name = '';
        this.comment = '';
        this.time = '';
    },
    deleteRecord: function(id){
        let formData = new FormData();
        formData.append( 'id',id)
        var comment = {};
        formData.forEach(function(value, key){
            comment[key] = value;
        });

        axios({
            method: 'post',
            url: 'api/delete.php',
            data: formData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
            app.getCom();
        })
        .catch(function (response) {
            console.log(response)
        });
    },
  }
}
)    
</script>