/*
SELECT user_id FROM abpee03.wp_usermeta where meta_key = 'wp_capabilities' AND meta_value = 'a:1:{s:13:"administrator";b:1;}';
SELECT user_id FROM abpee03.wp_usermeta where meta_key = 'wp_userlevel' AND meta_value = '10';
SELECT user_id FROM abpee03.wp_usermeta WHERE meta_key = 'wp_capabilities' AND meta_value = 'a:1:{s:10:"subscriber";b:1;}';
SELECT user_id FROM abpee03.wp_usermeta where meta_key = 'wp_user_level' AND meta_value = '0';
CREATE VIEW `Situacao quite` AS
*/

SELECT USERS.ID, USERS.user_login, USERS.user_email, USERS.ultimo_pgto, USERS.ultimo_recibo_quite
FROM abpee03.wp_users USERS
JOIN abpee03.wp_usermeta USMETA ON USERS.ID = USMETA.user_id
WHERE USMETA.meta_key = 'wp_user_level' AND USMETA.meta_value = '0';