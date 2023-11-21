let btn = document.querySelector("#btn-menu");
let sidebar = document.querySelector("#sidebar");
let arrow = document.querySelectorAll(".arrow");
var input = document.getElementsByClassName("input-form");


if(document.querySelector("#btn-menu")){
    btn.onclick = function(){
        sidebar.classList.toggle("active");
    }
}

for (var i = 0; i<arrow.length; i++){
    arrow[i].addEventListener("click",(e)=>{
        let arrowParent = e.target.parentElement.parentElement;
        console.log(arrowParent);
        arrowParent.classList.toggle("showMenu");
    });
}

for(var i = 0; i < input.length; i++){
    input[i].addEventListener('change', function(){
        if(this.value.length>=1){
            this.nextElementSibling.classList.add('fijar');
        }
        else{
            this.nextElementSibling.classList.remove('fijar');
        }
    })
}
