create database prenoms;
create role prenoms_admin password 'admin' login;
grant all on database prenoms to prenoms_admin;