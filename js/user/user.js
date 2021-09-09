const usersList = document.querySelector("#user-know"),
searchUser = document.querySelector("#search_user");

searchUser.onkeyup = () =>{
    let searchTerm = searchUser.value;
    if(searchUser != ""){
        searchUser.classList.add("active");
    }
    else {
        searchUser.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();// tạo sml object
    xhr.open("POST","ajax.php?action=search-user",true),
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                //console.log(data); 
                usersList.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhr.send("searchTerm="+ searchTerm);
}

$(".btn-addfriend").click(function (e){
    var user_id_add = $(this).attr('user-id-add');
    var user_friend_add = $(this).attr('user-friend-add');
    var actions = "add";
    console.log(user_id_add);
    $.ajax({
        url:'ajax.php?action=friend',
        method:'POST',
        data:{user_id_add:user_id_add,user_friend_add:user_friend_add,actions:actions},
        success:function(resp){
            if(resp){
                //console.log(resp);
                location.href = "home.php";
            }
        }
    })
});
$(".btn-delete-add").click(function (e){
    var user_id_add = $(this).attr('user-id-add');
    var user_friend_add = $(this).attr('user-friend-add');
    var actions = "delete";
    //console.log(user_friend_add);
    $.ajax({
        url:'ajax.php?action=friend',
        method:'POST',
        data:{user_id_add:user_id_add,user_friend_add:user_friend_add,actions:actions},
        success:function(resp){
            if(resp){
                //console.log(resp);
                location.href = "home.php";
            }
        }
    })
});
$(".btn-Accept-add").click(function (e){
    var user_id_add = $(this).attr('user-id-add');
    var user_friend_add = $(this).attr('user-friend-add');
    var actions = "accept";
    //console.log(user_friend_add);
    $.ajax({
        url:'ajax.php?action=friend',
        method:'POST',
        data:{user_id_add:user_id_add,user_friend_add:user_friend_add,actions:actions},
        success:function(resp){
            if(resp){
                //console.log(resp);
                location.href = "home.php";
            }
        }
    })
});

// const msg_form = document.querySelector("#msg_form");
// text_msg = msg_form.querySelector(".text-message");
// console.log(text_msg);
// text_msg.onkeyup(function(e){
//     if(e.which == 13 && e.shiftKey == false){
        
//         let xhr = new XMLHttpRequest();// tạo sml object
//             xhr.open("POST","ajax_insert_chat.php",true),
//             xhr.onload = () => {
//                 if(xhr.readyState === XMLHttpRequest.DONE){
//                     if(xhr.status === 200){

//                         let data = xhr.response;
//                         //console.log(data);  
//                          if(data == 'success'){
//                               location.href = "home.php";
//                         }
//                         // }else{
//                         //     errorMessage.textContent = data;
//                         // }
//                     }
//                 }
//             }
//         let formData = new FormData(msg_form);
//         xhr.send(formData);
// 		$(this).val('');
//         // $("#msg_form").serialize()
//     }
// });




// setInterval(()=>{
//     let xhr = new XMLHttpRequest();// tạo sml object
//     xhr.open("POST","ajax_user.php",true),
//     xhr.onload = () => {
//         if(xhr.readyState === XMLHttpRequest.DONE){
//             if(xhr.status === 200){
//                 let data = xhr.response;
//                 //console.log(data);
//                 if(!searchUser.classList.contains("active")){
//                     usersList.innerHTML = data;
//                 }
//             }
//         }
//     }
//     xhr.send();

// },1000);//function sẽ chạy sau 500ms

