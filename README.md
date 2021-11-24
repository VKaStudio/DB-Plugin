# SportsTeamsManagement

Contributor: Viktor Konopelko
Stable tag:  1.0
Tested up to:  5.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

***Plugin for working with a database. For example, the tables are prepared for sports teams.***

## Description

Custom plugin for working with a database.
When the plugin is activated, a new table is created in the database (table name: *db_plugin*)
The table contains 5 columns:

 - team_id 
 - team_name 
 - team_city 
 - team_state 
 - team_stadium

The plugin adds pages to the WordPress admin panel: 
the plugin page with the *output of the entire table* (implemented through the WP_List_Table class), the page for *adding new data*, *editing, deleting data*.

***If the plugin is removed, the db_plugin table is removed from the database along with it.***

## Installation

To install, you need to copy the plugin folder to the WordPress plugins directory  `/wp-content/plugins/`  and activate through the admin panel.

**Important!** 
You can rename the table name before it is created (*before activating the plugin*) in  the main *`db-plugin.php`* file 

    define ('PREFIX_DB', 'db_plugin');


