<?php
/**
 * @author Christoph Bessei
 * @version
 */

class Fum_Option_Page_Controller {

	public static $parent_slug = 'fum';
	public static $pages;

	public static function register_option_pages() {

	}

	public static function create_menu() {

		$pages = array();

		//Add General Settings Page
		$page = new Fum_Option_Page( 'general_settings_page', 'Allgemeine Einstellungen' );

		//Add General Settings Fum_Option Group
		$option_group = new Fum_Option_Group( Fum_Conf::$fum_general_option_group_hide_wp_login_php );
		$options      = array();

		//Create hide wordpress login and register page checkbox
		$name        = Fum_Conf::$fum_general_option_group_hide_wp_login_php;
		$title       = 'Verstecke das Wordpress Login - und Registrierungsformular';
		$description = 'Verstecke alle Wordpress Login und Registrierungsformulare, Login/Registrierung ist dann nur noch über die Frontend User Management Formulare mögliche';
		//Add option to option_group
		$options[] = new Fum_Option( $name, $title, $description, get_option( $name ), $option_group, 'checkbox' );

		//Create hide wordpress login and register page checkbox
		$name        = Fum_Conf::$fum_general_option_group_hide_dashboard_from_non_admin;
		$title       = 'Verstecke das Dashboard vor Benutzern ohne Administratorstatus';
		$description = 'Verhindere das normale Benutzer (ohne Administratorrechte) auf das Dashboard zugreifen können (Werden auf die Startseite umgeleitet).';

		//Add option to option_group
		$options[] = new Fum_Option( $name, $title, $description, get_option( $name ), $option_group, 'checkbox' );

		//Create hide wordpress login and register page checkbox
		$name        = Fum_Conf::$fum_register_form_use_activation_mail_option;
		$title       = 'Benutze Aktivierungsmails (Benutzerregistrierung)';
		$description = 'Verschicke eine E-Mail mit einem Aktivierungslink nach der Registrierung.';

		//Add option to option_group
		$options[] = new Fum_Option( $name, $title, $description, get_option( $name ), $option_group, 'checkbox' );


		//Create hide wordpress login and register page checkbox
		$name        = Fum_Conf::$fum_register_form_generate_password_option;
		$title       = 'Generiere Passwort bei Registrierung';
		$description = 'Der Benutzer bekommt ein automatisch generiertes Passwort per Mail zugeschickt.';

		//Add option to option_group
		$options[] = new Fum_Option( $name, $title, $description, get_option( $name ), $option_group, 'checkbox' );


		//Add created options to $option_group and register $option_group
		$option_group->set_options( $options );

		//Add all option groups to page
		$page->add_option_group( $option_group );


		//Add page to page array
		$pages[] = $page;


		self::$pages = $pages;

		//Add main menu
		add_menu_page( 'Frontend User Management', 'Frontend User Management', 'manage_options', self::$parent_slug, array( 'Fum_Option_Page_View', 'print_option_page' ) );
		//Add first submenu to avoid duplicate entries: http://wordpress.org/support/topic/top-level-menu-duplicated-as-submenu-in-admin-section-plugin
		add_submenu_page( self::$parent_slug, $pages[0]->get_title(), $pages[0]->get_title(), 'manage_options', self::$parent_slug );
		//remove first submenu because we used this already
		unset( $pages[0] );

		foreach ( $pages as $page ) {
			/*@var $page Fum_Option_Page */
			add_submenu_page( self::$parent_slug, $page->get_title(), $page->get_title(), 'manage_options', $page->get_name(), array( 'Fum_Option_Page_View', 'print_option_page' ) );
		}
	}


	public static function register_settings() {
		$pages = self::$pages;
		for ( $i = 0; $i < count( $pages ); $i ++ ) {
			$page = $pages[$i];
			foreach ( $page->get_option_groups() as $option_group ) {
				foreach ( $option_group->get_options() as $option ) {
					register_setting( $option_group->get_name(), $option->get_name() );
				}
			}
		}
	}
}