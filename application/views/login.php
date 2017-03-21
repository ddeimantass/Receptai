<article class="container">
    <div id='reg-info'><?php if (isset($reg)) echo $reg;?></div>
    <div id='err-info'><?php if (isset($remerr)) echo $remerr;?></div>
    <div class="row">
        <div class='col-sm-6'>
            <div class="panel panel-default prisijungimas">
                <div class="panel-body">
                    <div class="page-header">
                        <h1>Prisijungimas</h1>
                    </div>
                
                    <?php
                        echo form_open("http://localhost:8888/receptai/index.php/vartotojas/prisijungti");
                    ?>
                        <div id='err-info'><?php if (isset($prierr)) echo $prierr;?></div>
                    <?php                    
                        echo "<table><tr><td>El. paštas:</td><td>";
                        echo form_input('email', $this->input->post('email'));
                        echo "</td></tr>";

                        echo "<tr><td> Slaptažodis: </td><td>";
                        echo form_password("password");
                        echo "</td></tr>";

                        echo "<tr><td>";
                        echo form_submit('login_submit','Prisijungti');
                        echo "</td>";
                    
                        echo '<td><button type="button" id="remember">Pamiršau slaptažodį</button></td></tr></table>';

                        echo form_close();
                    ?>
                    
                </div>
            </div>
        </div>
        <div class='col-sm-6'>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="page-header">
                        <h1>Registracija</h1>
                    </div>
                    <?php
                        echo form_open("http://localhost:8888/receptai/index.php/vartotojas/registruotis");

                    ?>
                        <div id='err-info'><?php if (isset($regerr)) echo $regerr;?></div>
                    <?php

                        echo "<table><tr><td>El. paštas:</td><td>";
                        echo form_input('email', $this->input->post('email'));
                        echo "</td></tr>";

                        echo "<tr><td> Slaptažodis: </td><td>";
                        echo form_password("password");
                        echo "</td></tr>";
                    
                        echo "<tr><td> Slaptažodžio patvirtinimas: </td><td>";
                        echo form_password("cpassword");
                        echo "</td></tr>";

                        echo "<tr><td>";
                        echo form_submit('signup_submit','Registruotis');
                        echo "</td></tr></table>";

                        echo form_close();
                    ?>
                </div>
            </div>
        </div>
        <div class='col-sm-12' id="rememberForm">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="page-header">
                        <h1>Slaptažodžio priminimas</h1>
                    </div>
                    <?php
                        echo form_open("http://localhost:8888/receptai/index.php/site/prisijungimas");
                    ?>
                    <?php

                        echo "<h5> El. paštas:";
                        echo form_input('email', $this->input->post('email'));
                        echo "<h5>";

                        echo "<h5>";
                        echo form_submit('remember_submit','Priminti');
                        echo "<h5>";

                        echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</article>