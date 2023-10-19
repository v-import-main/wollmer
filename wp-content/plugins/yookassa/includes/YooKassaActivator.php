<?php

require_once plugin_dir_path(__FILE__) . 'YooKassaInstaller.php';

/**
 * Fired during plugin activation.
 */
class YooKassaActivator extends YooKassaInstaller
{
    /**
     * Activate YooKassa plugin
     *
     * @since    2.0.0
     */
    public static function activate()
    {
        self::update_db();

        self::log('info', 'YooKassa plugin activate!');
    }

    /**
     *
     */
    private static function update_db()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'yookassa_payment';
        $collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `payment_id`        CHAR(36) NOT NULL,
            `order_id`          INTEGER  NOT NULL,
            `status`            ENUM('pending', 'waiting_for_capture', 'succeeded', 'canceled') NOT NULL DEFAULT 'pending',
            `amount`            DECIMAL(11, 2) NOT NULL,
            `currency`          CHAR(3) NOT NULL DEFAULT 'RUB',
            `payment_method_id` CHAR(36) DEFAULT NULL,
            `paid`              ENUM('Y', 'N') NOT NULL DEFAULT 'N',
            `created_at`        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `captured_at`       DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            `updated_at`        DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            `receipt`           TEXT DEFAULT NULL,
            PRIMARY KEY (`payment_id`),
            KEY `{$table_name}_order_id` (`order_id`)
        ) $collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

}
