<article class="container" id="detaliai">
    <div class="panel panel-default">
        <div class="panel-body row">
            <div class="page-header col-xs-12">
                <h1><?php echo $recipe['title']; ?></h1>
            </div>
            <p class="col-xs-6">Recepto autorius: <?php echo $recipe['user']; ?></p>
            <p class="col-xs-6 laikas">Recepto įkėlimo laikas: <?php echo $recipe['upload_date']; ?></p>
            <h3 class="col-xs-12"><?php echo $recipe['description']; ?></h3>
        </div>
    </div>
</article>