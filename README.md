## Demo: API Authentication with Lumen and JWT.

### Usage:

At the root of project,

```
composer install

bower install

php artisan serve

tambahkan tabel user yg ada di folder db_update (SQL Server)

1. Untuk mendapatkan token, gunakan link ini pada postman
	localhost:8000/api/authenticate    -> POST Method

	Bulk Edit (postman):
		email:alf92@wiza.net
		password:secret

	email = yang ada di table users
	password = secret

2. Untuk mendapatkan data users, gunakan link ini pada postman
	localhost:8000/api/authenticate/user?token=xxxxxxxxxxxxxxxxxxxx   -> GET Method
	token didapat dari link pada nomor 1

3. Untuk decode token, gunakan link ini pada postman
	localhost:8000/api/decode?token=xxxxxxxxxxxxxxxxxxxx		  -> GET Method
	token didapat dari link pada nomor 1
	
```



