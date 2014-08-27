$(document).ready(function() {
   $("#Category").change(function(){
    if($("#Category").val()!='new'){
        $("#new_category").hide();
    }
    else{
        $("#new_category").show();
    }
   });
});