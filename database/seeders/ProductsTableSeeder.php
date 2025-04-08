<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Perruque Naturelle Brésilienne',
                'slug' => 'perruque-naturelle-bresilienne',
                'description' => 'Perruque en cheveux naturels, longueur 45cm, densité 150%, couleur naturelle. Idéale pour un look élégant et naturel.',
                'price' => 299,
                'category' => 1,
                'image' => 'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 5
            ],
            [
                'name' => 'Huile de Ricin Bio',
                'slug' => 'huile-de-ricin-bio',
                'description' => 'Huile nourrissante pour la croissance des cheveux. 100% naturelle et bio, sans additifs chimiques.',
                'price' => 19.99,
                'category' => 2,
                'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 4
            ],
            [
                'name' => 'Peigne Démêlant',
                'slug' => 'peigne-demelant',
                'description' => 'Peigne spécial pour cheveux bouclés et crépus. Démêle en douceur sans casser les cheveux.',
                'price' => 14.99,
                'category' => 3,
                'image' => 'https://images.unsplash.com/photo-1590159763121-7c9fd312190d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 4
            ],
            [
                'name' => 'Masque Capillaire Réparateur',
                'slug' => 'masque-capillaire-reparateur',
                'description' => 'Masque intensif pour cheveux abîmés. Répare et nourrit en profondeur.',
                'price' => 24.99,
                'category' => 2,
                'image' => 'https://images.unsplash.com/photo-1608248597279-f99d160bfcbc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 5
            ],
            [
                'name' => 'Perruque Synthétique Courte',
                'slug' => 'perruque-synthetique-courte',
                'description' => 'Perruque synthétique de haute qualité, coupe courte moderne, légère et confortable.',
                'price' => 149.99,
                'category' => 1,
                'image' => 'https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 4
            ],
            [
                'name' => 'Shampooing Sans Sulfate',
                'slug' => 'shampooing-sans-sulfate',
                'description' => 'Shampooing doux sans sulfate pour tous types de cheveux. Nettoie en douceur sans agresser.',
                'price' => 12.99,
                'category' => 2,
                'image' => 'https://images.unsplash.com/photo-1594125311687-3b1b3eafa9f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 4
            ],
            [
                'name' => 'Bonnet de Protection',
                'slug' => 'bonnet-de-protection',
                'description' => 'Bonnet en satin pour protéger vos cheveux pendant la nuit. Réduit les frottements et la casse.',
                'price' => 9.99,
                'category' => 3,
                'image' => 'https://images.unsplash.com/photo-1583500178450-e59e4309b57a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 5
            ],
            [
                'name' => 'Sérum Pointes Fourchues',
                'slug' => 'serum-pointes-fourchues',
                'description' => 'Sérum réparateur pour pointes fourchues. Scelle et protège les pointes fragilisées.',
                'price' => 17.99,
                'category' => 2,
                'image' => 'https://images.unsplash.com/photo-1617897903246-719242758050?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 4
            ],
            [
                'name' => 'Perruque Afro Naturelle',
                'slug' => 'perruque-afro-naturelle',
                'description' => 'Perruque afro en cheveux naturels, volume généreux, coupe courte stylée.',
                'price' => 249.99,
                'category' => 1,
                'image' => 'https://images.unsplash.com/photo-1541576980233-97577392db9a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 5
            ],
            [
                'name' => 'Brosse Plate Démêlante',
                'slug' => 'brosse-plate-demelante',
                'description' => 'Brosse plate spéciale démêlage, idéale pour tous types de cheveux.',
                'price' => 11.99,
                'category' => 3,
                'image' => 'https://images.unsplash.com/photo-1590439471364-192aa70c0b53?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 4
            ],
            [
                'name' => 'Huile d\'Argan Pure',
                'slug' => 'huile-dargan-pure',
                'description' => 'Huile d\'argan 100% pure pour nourrir et faire briller les cheveux.',
                'price' => 22.99,
                'category' => 2,
                'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 5
            ],
            [
                'name' => 'Extensions à Clip Naturelles',
                'slug' => 'extensions-a-clip-naturelles',
                'description' => 'Extensions à clip en cheveux naturels, longueur 50cm, plusieurs teintes disponibles.',
                'price' => 129.99,
                'category' => 1,
                'image' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'rating' => 4
            ]
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category_id' => $product['category'],
                'image' => $product['image'],
                'rating' => $product['rating']
            ]);
        }
    }
}
