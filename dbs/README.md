load the db

    sqlite3 site.sqlite < site.sql
    sqlite3 site.sqlite

queries

    select * from users;
    select * from shops;
    select * from shops join users using (user_id);



