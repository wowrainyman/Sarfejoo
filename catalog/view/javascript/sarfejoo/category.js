$(document).ready(function()
{
     $(".compare").click(function() 
     {
       $(this).find('a.compare-add').toggle();
       $(this).find('a.compare-remove').toggle();
     }); 
});