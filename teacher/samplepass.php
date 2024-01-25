<html>
<head>
</head>
<style>
* {
  margin:0px;
  padding:0px;
  box-sizing:border-box;
}
body {
  font-family:"Raleway",sans-serif;
  background:#f0f0f0;
}
.pw-meter {
  position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
  width:350px;
  background:#fff;
  padding:20px;
  box-shadow:0px 0px 20px 5px rgba(0,0,0,0.05);
}
.pw-meter h2 {
  margin:10px 0px 30px;
  font-size:20px;
  color:#111;
  text-align:center;
}
.pw-meter .form-element {
  position:relative;
}
.pw-meter label {
  display:block;
  margin-bottom:8px;
  color:#111;
}
.pw-meter input {
  padding:8px 30px 8px 10px;
  width:100%;
  font-size:16px;
  border:1px solid #bbb;
  outline:none;
}
.pw-meter .pw-display-toggle-btn {
  position:absolute;
  right:10px;
  top:35px;
  width:20px;
  height:20px;
  text-align:center;
  line-height:20px;
  cursor:pointer;
}
.pw-meter .pw-display-toggle-btn i.fa-eye-slash {
  display:none;
}
.pw-meter .pw-display-toggle-btn.active i.fa-eye-slash {
  display:block;
}
.pw-meter .pw-display-toggle-btn.active i.fa-eye {
  display:none;
}
.pw-meter .pw-strength {
  position:relative;
  width:100%;
  height:20px;
  margin-top:10px;
  text-align:center;
  background:#f2f2f2;
  display:none;
}
.pw-meter .pw-strength span:nth-child(1) {
  position:relative;
  font-size:13px;
  color:#111;
  z-index:2;
  font-weight:600;
}
.pw-meter .pw-strength span:nth-child(2) {
  position:absolute;
  top:0px;
  left:0px;
  width:0%;
  height:100%;
  border-radius:5px;
  z-index:1;
  transition:all 300ms ease-in-out;
}
</style>
<body>
<div class="pw-meter">
  <h2>Password Strength Meter</h2>
  <div class="form-element">
    <label for="password">Password</label>
    <input type="password" id="password">
    <div class="pw-display-toggle-btn">
      <i class="fa fa-eye"></i>
      <i class="fa fa-eye-slash"></i>
    </div>
    <div class="pw-strength">
      <span>Weak</span>
      <span></span>
    </div>
  </div>
</div>
</body>
<script>
function getPasswordStrength(password){
  let s = 0;
  if(password.length > 6){
    s++;
  }
  if(password.length > 10){
    s++;
  }
  if(/[A-Z]/.test(password)){
    s++;
  }
  if(/[0-9]/.test(password)){
    s++;
  }
  if(/[^A-Za-z0-9]/.test(password)){
    s++;
  }
  return s;
}
document.querySelector(".pw-meter #password").addEventListener("focus",function(){
  document.querySelector(".pw-meter .pw-strength").style.display = "block";
});
document.querySelector(".pw-meter .pw-display-toggle-btn").addEventListener("click",function(){
  let el = document.querySelector(".pw-meter .pw-display-toggle-btn");
  if(el.classList.contains("active")){
    document.querySelector(".pw-meter #password").setAttribute("type","password");
    el.classList.remove("active");
  } else {
    document.querySelector(".pw-meter #password").setAttribute("type","text");
    el.classList.add("active");
  }
});

document.querySelector(".pw-meter #password").addEventListener("keyup",function(e){
  let password = e.target.value;
  let strength = getPasswordStrength(password);
  let passwordStrengthSpans = document.querySelectorAll(".pw-meter .pw-strength span");
  strength = Math.max(strength,1);
  passwordStrengthSpans[1].style.width = strength*20 + "%";
  if(strength < 2){
    passwordStrengthSpans[0].innerText = "Weak";
    passwordStrengthSpans[0].style.color = "#111";
    passwordStrengthSpans[1].style.background = "#d13636";
  } else if(strength >= 2 && strength <= 4){
    passwordStrengthSpans[0].innerText = "Medium";
    passwordStrengthSpans[0].style.color = "#111";
    passwordStrengthSpans[1].style.background = "#e6da44";
  } else {
    passwordStrengthSpans[0].innerText = "Strong";
    passwordStrengthSpans[0].style.color = "#fff";
    passwordStrengthSpans[1].style.background = "#20a820";
  }
});
</script>
</html>