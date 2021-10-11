# Coding-Challenge-Software-Engineer-application-by-Mouad-ADLI

---

## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- Run __npm install__ 
- Run __npm run dev__ 
- That's it: launch the main URL


# to create and delete a product or category from the command line
- Run __php artisan product:create --name= --description= --price= --category_id=__
- Run __php artisan product:delete --id=__
- Run __php artisan category:create name category_parent__ (optional)
- Run __php artisan category:delete --id=__


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).