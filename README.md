git clone git@bitbucket.org:field-design/cms.git newname

cd newname

rm -rf .git

mv .env.example .env

//update .env with app name, author and database 

composer update

php artisan migrate

php artisan db:seed

npm install

npm run build



# setup valet or manp

https://newname.dev/admin

login as admin@test.com / password

https://newname.dev/admin/profile

change details.