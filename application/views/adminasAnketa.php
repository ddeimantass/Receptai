<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); echo doctype('html5');

    $users_pagination = "<div class=\"pagination\">";
    $users_pagination .= "Puslapiai: ";
    for ($i = 1;$i <= $total_users_pages;$i++) {
      if ($i == $current_users_page) {
          $users_pagination .= " <span>$i</span>";
      } else {
          $users_pagination .= " <a href='".base_url()."index.php/vartotojas/adminasAnketa?";
          $users_pagination .= "u=$i&r=$current_recipes_page'>$i</a>";
      }
    }
    $users_pagination .= "</div>";

    $recipes_pagination = "<div class=\"pagination\">";
    $recipes_pagination .= "Puslapiai: ";
    for ($i = 1;$i <= $total_recipes_pages;$i++) {
      if ($i == $current_recipes_page) {
          $recipes_pagination .= " <span>$i</span>";
      } else {
          $recipes_pagination .= " <a href='".base_url()."index.php/vartotojas/adminasAnketa?";
          $recipes_pagination .= "r=$i&u=$current_users_page'>$i</a>";
      }
    }
    $recipes_pagination .= "</div>";

?>
<html>
<head>
    <title>Receptų administratorius</title>
    <meta charset="UTF-8">
    <link rel="stylesheet"  href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"  href="<?php echo base_url();?>styles.css">
    <link rel="stylesheet"  href="<?php echo base_url();?>animate.css">
</head>
<body class='container' id='adminA'>
    <article class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="page-header">
                    <h1>Administratoriaus anketa</h1>
                </div>
                <div class="">
                    <a id='atsijungti' href="<?php echo base_url();?>index.php/vartotojas/administratorius" class="btn btn-danger">Atsijungti</a>
                    <a id='puslapi' href="<?php echo base_url();?>index.php/site/pagrindinis" class="btn btn-success">Į puslapį</a>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="page-header">
                    <h1>Naudotojai</h1>
                </div>
                <div class='read'>
                    <?php echo $users_pagination; ?>
                    <table class='usersInfo' align="center">
                        <?php if(isset($users)){
                            foreach ($users as $user) {
                                echo "<tr><td>".$user["id"].".</td><td class='title' > ".$user["email"]."</td><td><button id='".base_url()."index.php/CRUD/delete/".$user["id"]."' class='btn btn-danger r'>X</button></td></tr>";
                                }
                            }
                            else{
                                echo "<h2>Įrašų nėra</h2>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="page-header">
                    <h1>Receptai</h1>
                </div>
                <div class='readr'>
                    <div id='err-info'><?php if (isset($aderr)) echo $aderr;?></div>
                    <div id='reg-info'><?php if (isset($reg)) echo $reg;?></div>
                    <?php echo $recipes_pagination; ?>
                    <table class='usersInfo' align='center' >
                        <?php if(isset($recipes)){
                            foreach ($recipes as $recipe) {
                                if($recipe["publish"] != 1)
                                    echo "<tr id='".$recipe["id"]."' style='background: #008fd5; color: #fff'>";
                                else
                                    echo "<tr id='".$recipe["id"]."'>";
                                echo "<td>".$recipe["id"].".</td>
                                <td class='title' > ".$recipe["title"]."</td>
                                <td class='hide'><textarea class='hide'>".$recipe["description"]."</textarea></td>
                                <td><button class='btn btn-success' onclick='btnEdit(\"".$recipe["id"]."\",\"".$recipe["title"]."\",\"".$recipe["user"]."\",\"".$recipe["type"]."\")'>Peržiūrėti</button></td>
                                <td><button id='".base_url()."/index.php/CRUD/deleteReview/".$recipe["id"]."' class='btn btn-danger r'>X</button></td>
                                </tr>";
                                }
                            }
                            else{
                                echo "<h2>Įrašų nėra</h2>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default " id='redaguoti'>
            <div class="panel-body">
                <div class="page-header">
                    <h1>Redaguoti receptą</h1>
                </div>
                <div>
                <?php 
                    echo form_open('index.php/CRUD/updateReview');
                    
                    $id = array(
                        'id' => 'recipe_id',
                        'name' => 'id',
                        'type' => 'hidden',
                    );
                    $admin = array(
                        'name' => 'admin',
                        'value' => $this->session->userdata('vardas'),
                        'type' => 'hidden',
                    );
                    $user = array(
                        'id' => 'recipe_user',
                        'name' => 'user',
                        'type' => 'hidden',
                    );
                    
                    $title = array(
                        'name' => 'title',
                        'id' => 'recipe_title',
                    );
                    $description = array(
                        'name'  => 'description',
                        'type'  => 'text',
                        'id'    => 'recipe_description',
                    );
                    $type = array(
                        'id'   => 'recipe_type',
                        'name' => 'type',
                        'type' => 'text'
                    );
                    echo form_input($id, $this->input->post('id'));
                    echo form_input($user, $this->input->post('user'));
                    echo form_input($admin, $this->input->post('admin'));
                    echo form_input($title, $this->input->post('title'));
                    echo form_input($type, $this->input->post('type'));
                    echo form_textarea($description, $this->input->post('description'));
                    echo form_submit('edit_submit','Išsaugoti');
                    echo form_close();
                ?>
                </div>
            </div>
        </div>
        <div id="popupas">
            <p></p>
            <input type="hidden">
            <button id="delete" class="btn btn-danger">Pašalinti</button>
            <button id="cancel" class="btn btn-primary">Atšaukti</button>
        </div>
    </article>
    <script src = "//code.jquery.com/jquery-2.2.1.min.js"></script>
    <script src= '<?php echo base_url();?>animate.js' type="text/javascript"></script>
    
    <script type="text/javascript">
        function btnEdit(id,title,user,type){
            $('#redaguoti').show();
            $('#recipe_id').val(id);
            $('#recipe_title').val(title);
            $('#recipe_user').val(user);
            $('#recipe_description').text($("tr#"+id+" textarea.hide").text());
            $('#recipe_type').val(type);
        }
        $("body").on("click",".btn.r", function(){
            var title = "Ar tikrai norite pašalinti";
            $("#popupas input").val($(this).attr("id"));
            $("#popupas p").text(title+" "+$(this).parent().siblings(".title").text());
            $("#popupas").show();
        });
        $("body").on("click","#cancel", function(){
            $("#popupas").hide();
        });
        $("body").on("click","#delete", function(){
            $.post( $("#popupas input").val(), function( data ) {
                $("#popupas").hide();
                location.reload();
            });
            
        });
    </script>
</body>
</html>
