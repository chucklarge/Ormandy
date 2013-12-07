DROP TABLE IF EXISTS users;

CREATE TABLE users (
user_id INT UNSIGNED NOT NULL DEFAULT 0,
first_name TEXT NOT NULL,
last_name TEXT NOT NULL,
email TEXT NOT NULL,
create_date INT UNSIGNED NOT NULL DEFAULT 0,
update_date INT UNSIGNED NOT NULL DEFAULT 0,
PRIMARY KEY (user_id)
);

insert into users values(1, 'chuck', 'close', 'cc@email.com', 1276473600, 1276473600);
insert into users values(2, 'george', 'jones', 'gj@email.com', 1295827200, 1295827200);
insert into users values(3, 'alex', 'smith', 'as@email.com', 1309564800, 1309564800);
insert into users values(4, 'john', 'benotto', 'jb@email.com', 1315008000, 1315008000);
insert into users values(5, 'peter', 'ryan', 'pr@email.com', 1323734400, 1323734400);
