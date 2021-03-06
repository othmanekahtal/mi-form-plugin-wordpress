<?php
/**
 * Plugin Name:       MI form creator
 * Plugin URI:        https://github.com/othmanekahtal/mi-form-plugin-wordpress
 * Description:       MI form creator is a basic plugin for creating a dynamic form
 * Version:           1.0
 * Author:            Othmane Kahtal
 * Author URI:        https://github.com/othmanekahtal/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */


if (!defined('ABSPATH')) {
    die;
}

function mi_form_plugin(): string
{
    global $wpdb;
    $options = $wpdb->get_row(/** @lang sql */ "SELECT * FROM wp_mi_creator_fields WHERE id = 1;", object);
    $div = '<form method="POST" action="" style="display: grid">';
    if ($options->username) {
        $div .= '<label>username:</label>';
        $div .= '<input type="text" name="username" placeholder="username"><br>';
    }
    if ($options->email) {
        $div .= '<label>Email:</label>';
        $div .= '<input type="text" name="email" placeholder="Email"><br>';
    }
    if ($options->subject) {
        $div .= '<label>Subject:</label>';
        $div .= '<input type="text" name="subject" placeholder="Subject"><br>';
    }
    if ($options->message) {
        $div .= '<label>Message:</label>';
        $div .= '<textarea style="resize: vertical;height:200px;" name="message" placeholder="Message"></textarea><br>';
    }
    $div .= '<input type="submit" name="submit"><br>';
    $div .= '</form>';
    return $div;
}

function menu()
{
    add_menu_page('MI creator form', 'MI creator form', 'manage_options', 'MI creator form', 'display_menu', 'dashicons-tagcloud', 200);
}

function display_menu()
{
    ?>
    <div class="content">

        <div class="wrap">
            <h1>Welcome to MI creator form plugin :</h1>
            <p>can create and manage your custom form , also MI creator support data insertion in your database.
                <mark>MI creator Form is FOSS🤍</mark>
            </p>
            <p><b>NOTE:</b> shortcode for implement the plugin functionality <strong>[mi-form]</strong></p>
        </div>
        <div class="main">
            <div class="main-opt">
                <div class="option form-setting active--option">
                    form setting
                </div>
                <div class="option form-data">
                    form data
                </div>
            </div>
            <div class="option-content">
                <div class="options-form">
                    <h1>Custom form Options :</h1>
                    <form method="POST" action="">
                        <div class="input-group">
                            <label for="name">Username :</label>
                            <?php
                            global $wpdb;
                            $result = $wpdb->get_row(/** @lang sql */ "select * FROM wp_mi_creator_fields where id = 1 ",
                                object);
                            echo '<input type="checkbox" name="username" id="name" ';
                            echo $result->username ? 'checked' : '';
                            echo '>
                            </div>
                    <div class="input-group">
                        <label for="email">Email :</label>
                        <input type="checkbox" name="email" id="email"';
                            echo $result->email ? 'checked' : '';
                            echo '/>
                    </div>
                    <div class="input-group">
                            <label for="subject">Subject :</label>
                            <input type="checkbox" name="subject" id="subject" ';
                            echo $result->subject ? 'checked' : '';
                            echo '>
                           </div>
                        <div class="input-group">
                            <label for="message">Message :</label>
                            <input type="checkbox" name="message" id="message" ';echo $result->message ? 'checked' : '';
                            echo '></div>';
                    ?>
                            <div class="input-group">
                                <input type="submit" class="button button-primary" name="submit-setting">
                            </div>
                    </form>
                </div>
                <div class="data-forms hidden-content">
                    <h1>data Forms :</h1>
                    <?php
                    global $wpdb;
                    $results = $wpdb->get_results(/** @lang sql */ "SELECT * FROM wp_mi_creator_fields_data");
                    echo '<table>
                              <tr>
                                <th>id</th>
                                <th>username</th>
                                <th>email</th>
                                <th>subject</th>
                                <th>message</th>

                              </tr>';
                    foreach ($results as $row) {
                        echo "
                          <tr>
                            <td>" . $row->id . "</td>
                            <td>" . $row->username . "</td>
                            <td>" . $row->email . "</td>
                            <td>" . $row->subject . "</td>
                            <td>" . $row->message . "</td>

                          </tr>
                        ";
                    }
                    echo '</table>'
                    ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        .content {
            width: calc(100% - 20px);
            height: 85vh;
            padding-right: 20px;
        }

        .main {
            width: 100%;
            position: relative;
        }

        .main-opt {
            display: flex;
            align-content: center;
        }

        .main-opt > div {
            text-align: center;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: 700;
            flex-basis: 50%;
            padding: 15px;
            background-color: white;
            border: 2px solid transparent;
            transition: all .25s linear;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .main-opt > div:hover {
            background-color: #eeeeee;
            border-color: #4b4a4a;
        }

        .option-content > div {
            width: 75%;
        }

        .main-opt > div:active, .active--option {
            background-color: #dcdcdc !important;
            border-color: #000000 !important;
        }

        .hidden-content {
            display: none;
        }

        .options-form form {
            display: flex;
            align-items: center;
            flex-direction: column;
            row-gap: 25px
        }

        form .input-group {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        h1 {
            margin-top: 15px;
            margin-bottom: 45px;
        }

        mark {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .option-content {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 81vh;
        }

    </style>
    <script>
        let options = document.querySelector('.main-opt');
        let setting_form = document.querySelector('.options-form');
        let data_form = document.querySelector('.data-forms');
        options.addEventListener('click', function () {
            console.log("dd")
            let targetChild = event.target;
            console.log(targetChild)
            if (!targetChild.classList.contains('option')) return;
            document.querySelectorAll('.option').forEach(element => {
                if (element.classList.contains('active--option')) {
                    element.classList.remove('active--option')
                }
            })
            targetChild.classList.add('active--option');
            if (targetChild.classList.contains('form-setting')) {
                data_form.classList.add('hidden-content');
                setting_form.classList.remove('hidden-content');
            }
            if (targetChild.classList.contains('form-data')) {
                data_form.classList.remove('hidden-content');
                setting_form.classList.add('hidden-content');
            }
        })
    </script>
    <?php
}

function settings_page()
{

}

function create_table_for_data_of_fields()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = /** @lang sql */
        "CREATE TABLE " . $wpdb->base_prefix . "mi_creator_fields_data (
        id int AUTO_INCREMENT,
        username varchar(255) ,
        email varchar(255) ,
        subject varchar(255),
        message varchar(255),
        at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY key(id)
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    maybe_create_table($wpdb->base_prefix . "mi_creator_fields_data", $sql);
}

function create_table_for_fields()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = /** @lang sql */
        "CREATE TABLE " . $wpdb->base_prefix . "mi_creator_fields (
        id INT,
        username BOOLEAN,
        email BOOLEAN,
        subject BOOLEAN,
        message BOOLEAN
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    maybe_create_table($wpdb->base_prefix . 'mi_creator_fields', $sql);
    $wpdb->insert(
        $wpdb->base_prefix . 'mi_creator_fields',
        array(
            'id' => 1,
            'username' => true,
            'email' => true,
            'subject' => true,
            'message' => true
        )
    );
}

function setup_plugin_option()
{
    create_table_for_data_of_fields();
    create_table_for_fields();
}

function deactivation_plugin_option()
{
    global $wpdb;
    $wpdb->query(/** @lang sql */ "DROP TABLE IF EXISTS wp_mi_creator_fields");

}

function update_status_of_fields()
{
    $username = false;
    $email = false;
    $subject = false;
    $message = false;
    if (isset($_POST['username']) && $_POST['username'] == 'on') $username = true;
    if (isset($_POST['message']) && $_POST['message'] == 'on') $message = true;
    if (isset($_POST['subject']) && $_POST['subject'] == 'on') $subject = true;
    if (isset($_POST['email']) && $_POST['email'] == 'on') $email = true;
    global $wpdb;
    unset($_POST['submit-setting']);
    $wpdb->update(
        'wp_mi_creator_fields',
        array('email' => $email, 'username' => $username, 'message' => $message, 'subject' => $subject),
        ['id' => 1]
    );
}

function insert_data_fields()
{
    global $wpdb;
    unset($_POST['submit']);
    $wpdb->insert('wp_mi_creator_fields_data', $_POST);
}

if (isset($_POST['submit'])) {
    insert_data_fields();
}
if (isset($_POST['submit-setting'])) {
    update_status_of_fields();
}
// add actions :
add_action('admin_menu', 'menu');
// activate plugin action :
register_activation_hook(__FILE__, 'setup_plugin_option');
// deactivate plugin action :
register_deactivation_hook(__FILE__, 'deactivation_plugin_option');
// uninstall plugin action :
add_shortcode('mi-form', 'mi_form_plugin');
