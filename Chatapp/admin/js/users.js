const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list");

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.send();
}, 500);

function deleteUser(userId) {
  if(confirm("Are you sure you want to delete this user?")) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/delete-user.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(data === "success"){
            alert("User deleted successfully!");
          } else {
            alert("Error deleting user!");
          }
        }
      }
    }
    xhr.send("user_id=" + userId);
  }
}
