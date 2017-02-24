<?php echo doctype('html5');?>
<html>
<head>
    <title>Rubinas adminas</title>
    <meta charset="UTF-8">
    <link rel="stylesheet"  href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"  href="<?php echo base_url();?>styles.css">
    <link rel="stylesheet"  href="<?php echo base_url();?>animate.css">
</head>
<body class='container' id="adminlog">
<?php
    echo form_open("http://localhost:8888/receptai/index.php/vartotojas/adminasPrisijungti");

    if (isset($prierr)) echo $prierr;

    echo "<h2> vardas: <label>";
    $data = array(
        'maxlength'  => '20',
        'name' => 'vardas',
    );
    echo form_input($data);
    echo "</label><h2>";

    echo "<h2> Slaptažodis: <label>";
    echo form_password("slaptazodis");
    echo "</label><h2>";


    echo "<h1>";
    echo form_submit('login_submit','Prisijungti');
    echo "<h1>";

    echo form_close();
?>
</body>
</html>