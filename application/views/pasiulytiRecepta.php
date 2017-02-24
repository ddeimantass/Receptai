    <article class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="page-header">
                    <h1>Pasiūlyti receptą</h1>
                </div>
                <div id='reg-info'><?php if (isset($reg)) echo $reg;?></div>
                <div id='err-info'><?php if (isset($uperr)) echo $uperr;?></div>
                <div>
                    <div class='rasyti_ats'>
                    <?php echo form_open('index.php/CRUD/create');?>
                    <?php
                        $user = array(
                            'name'          => 'user',
                            'type'          => 'hidden',
                            'value'         => $user_email
                        );
                        $title = array(
                            'name'          => 'title',
                            'type'          => 'text',
                            'id'            => 'recipe_title',
                            'placeholder'   => 'Recepto pavadinimas',
                        );
                        $description = array(
                            'name'          => 'description',
                            'type'          => 'text',
                            'id'            => 'recipe_description',
                            'placeholder'   => 'Recepto aprašymas',
                        );
                        $options = array(
                            'Maistas'         => 'Maistas',
                            'Gėrimas'        => 'Gėrimas'
                        );

                        echo form_input($user);
                        echo form_input($title, $this->input->post('title'));
                        echo form_dropdown('type', $options, $this->input->post('type'));
                        echo form_textarea($description, $this->input->post('description'));
                        echo form_submit('suggest_submit','Pasiūlyti');

                        echo form_close();
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </article>