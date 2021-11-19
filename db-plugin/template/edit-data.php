<h4>Edit value in DataBase tables</h4>
<form action="<?= get_admin_url( null, 'admin.php?page=edit_data_db' );?> " method="post">
    <?php wp_nonce_field( "db-plugin/db-plugin.php", 'db_plugin_noncename' ); ?>
    <input id="id-team-plugin-db" name="id-team-input" value="<?= $row["team_id"] ?>" type="text">
    <label for="id-team-plugin-db"><?= __('Team ID', 'dbplugin')?></label><br>
    <input id="name-team-plugin-db" name="name-team-input" value="<?= $row["team_name"] ?>" type="text">
    <label for="name-team-plugin-db"><?= __('Team Name', 'dbplugin')?></label><br>
    <input id="city-team-plugin-db" name="city-team-input" value="<?= $row["team_city"] ?>" type="text">
    <label for="city-team-plugin-db"><?= __('Team City', 'dbplugin')?></label><br>
    <input id="state-team-plugin-db" name="state-team-input" value="<?= $row["team_state"] ?>" type="text">
    <label for="state-team-plugin-db"><?= __('Team State', 'dbplugin')?></label><br>
    <input id="stadium-team-plugin-db" name="stadium-team-input" value="<?= $row["team_stadium"] ?>" type="text">
    <label for="stadium-team-plugin-db"><?= __('Team Stadium', 'dbplugin')?></label><br>
    <button type="submit" class="writeDataDB"><?= __('Save', 'dbplugin')?></button>
</form>
<?php
    $value_output = (!empty($result));
    if($value_output) {
        echo __('saved!', 'dbplugin');
    }
?>