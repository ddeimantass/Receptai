    <article class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="page-header">
                    <h1>Anketa</h1>
                </div>
                <div>
                    <h2 class='anketa-h2'>Sveiki, čia jūsų anketos puslapis, į kurį galite patekti tik jūs</h2>
                    <h2 class='anketa-h2'><a id='atsijungti' href="<?php echo base_url();?>index.php/vartotojas/atsijungti" class="btn btn-danger">Atsijungti</a></h2>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="page-header">
                    <h1>Atnaujinti slaptažodį</h1>
                </div>
                <div id='reg-info'><?php if (isset($reg)) echo $reg;?></div>
                <?php 
                    echo form_open('index.php/CRUD/update');

                ?>
                    <div id='err-info'><?php if (isset($uperr)) echo $uperr;?></div>
                <?php

                    echo "<table><tr>";

                    echo "<td><h4> Įveskite savo el. paštą:";
                    echo form_input('email',$this->input->post('email'));
                    echo "<h4></td>";

                    echo "<td><h4> Įveskite savo naujajį slaptažodį:";
                    echo form_password("password");
                    echo "<h4></td>";

                    echo "<td><h4> Pakartotinai įveskite savo naujajį slaptažodį:";
                    echo form_password("cpassword");
                    echo "<h4></td>";

                    echo "<td><h4>";
                    echo form_submit('login_submit','Atnaujinti');
                    echo "<h4></td>";

                    echo "</tr></table>";

                    echo form_close();
                ?>
            </div>
        </div>
    </article>