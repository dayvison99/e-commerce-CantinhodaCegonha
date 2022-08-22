<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'canti997_cantinhodb' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'secreta123' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'bIhUaBG.*DHZ!3DE3]@PDQy 24@jpAr#6A&UI6;-#l{Ie0VM4$8HQgoj-]D?,:kW' );
define( 'SECURE_AUTH_KEY',  'T7TQ+HUzaI@BVS}G}J!@s.=9rZtu/%@&!vYwDP%n+$FdR|WP<gwO8ZK0!PQG9Ycw' );
define( 'LOGGED_IN_KEY',    'os$}]rhD _Jn(qPM!&g<GgIj8/|(|H3^D9th^1w:M4XvSa}eI~pMCiR(. ?C5Q`g' );
define( 'NONCE_KEY',        'InDFx1>vt!oy7g1&Rw`_*zOYOzlSypHq_1X~09&aUqVY_]gWXhz{y7o]!>cr{M/l' );
define( 'AUTH_SALT',        ':QDxj/Pop;-nnDI.uq,M^b/?]T/fT|hG<<LawL:n}j(pqtaVof%S[zm6G_f]2; @' );
define( 'SECURE_AUTH_SALT', '3`20MRHqI{==aDu%n2cLS/_If0Z6E>jWU@O0~{s W}P%ehs;m-4*hL=/Y$=G;.d/' );
define( 'LOGGED_IN_SALT',   'm3rA0VQ(duayy7)3Z(GIJ34j8:_UzzF8,:nAzl`q?7s3P {{z6uZi7btJQ|L2g~c' );
define( 'NONCE_SALT',       'N$jSg.YZv5EpFAQ!G$h}W  lke{@&Sa5<O[]ToISs81u[aI sMUAI?IN~qznQDom' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'cg_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
