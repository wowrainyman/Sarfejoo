$(document).ready(function()
{
     $("tr:even").css("background-color", "#F3F8F3");
     $("#dif").click(function(){
       $(".c-dif-tr").toggleClass("c-dif");
       $("#dif").toggleClass("tiked-r");
     }); 
});