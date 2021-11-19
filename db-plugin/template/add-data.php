<h4><? _e('Add data to DataBase tables', 'dbplugin') ?></h4>
<form action="<?= get_admin_url( null, 'admin.php?page=create_data_db' );?>" method="post">
    <?php wp_nonce_field( "db-plugin/db-plugin.php", 'db_plugin_noncename' ); ?>
    <input id="name-team-plugin-db" name="name-team-input" type="text">
    <label for="name-team-plugin-db"><? _e('Team Name', 'dbplugin') ?></label><br>
    <input id="city-team-plugin-db" name="city-team-input" type="text">
    <label for="city-team-plugin-db"><? _e('Team City', 'dbplugin') ?></label><br>
    <input id="state-team-plugin-db" name="state-team-input" type="text">
    <label for="state-team-plugin-db"><? _e('Team State', 'dbplugin') ?></label><br>
    <input id="stadium-team-plugin-db" name="stadium-team-input" type="text">
    <label for="stadium-team-plugin-db"><? _e('Team Stadium', 'dbplugin') ?></label><br>
    <button type="submit" class="writeDataDB"><? _e('add row to DB', 'dbplugin') ?></button>
</form>
<table class="table table-dark output-data-db">
    <?php
        $value_output = (!empty($result));
        if($value_output) {
            echo __('New row saved!', 'dbplugin');
        }
    ?>
</table>