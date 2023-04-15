<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="form-group">
    <input class="form-control" type="text" id="search-users" value="" name="user" placeholder="Rechercher un utilisateur">
</div>

<div style="margin-top: 20px">
    <div id="result-search"></div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


<script>

$(document).ready(function(){
    $('#search-users').keyup(function(){
        $('#result-search').html('');
        var nom_utilisateur = $(this).val();

        if(nom_utilisateur != ""){
            $.ajax({
                type:'GET',
                url:'rechercheUsers.php',
                data:'users=' + encodeURIComponent(nom_utilisateur),
                success:function(data){
                    if(data != ""){
                        $('#result-search').append(data);
                    }else{
                        document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                    }

                }
            });
        }
    });
});

</script>


</body>


</html>