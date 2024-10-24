<?php

use Illuminate\Database\Seeder;
use App\Marca;
use App\Modelo;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Abarth
        $abarth =  Marca::create([
            'nombre' => 'Abarth'
        ]);
        $modelos = ['500'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $abarth->id
            ]);
        }

        //Acura,
        $acura = Marca::create([
            'nombre' => 'Acura'
        ]);
        $modelos = ['ILX','TLX','NSX','RDX SUV','MDX SUV'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $acura->id
            ]);
        }
        //Alfa Romeo
        $alfaRomero = Marca::create([
            'nombre' => 'Alfa Romeo',
        ]);
        $modelos = ['MiTo','Giulietta','4C','Giulia','Stelvio'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $alfaRomero->id
            ]);
        }

        //Aston Martin
        $astonMartin = Marca::create([
            'nombre' => 'Aston Martin',
        ]);
        $modelos = ['Rapide','Vantage','Vanquish','DB9','DB11'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $astonMartin->id
            ]);
        }

        //Audi
        $audi = Marca::create([
            'nombre' => 'Audi',
        ]);
        $modelos = ['A1','A3','A4','A5','A6','A7','A8','Q3','Q5','Q7','S3','TT','R8'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $audi->id
            ]);
        }

        //BAIC
        $baic = Marca::create([
            'nombre' => 'BAIC',
        ]);
        $modelos = ['D20','X25','X65','BJ40'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $baic->id
            ]);
        }

        //Bentley
        $bentley = Marca::create([
            'nombre' => 'BAIC',
        ]);
        $modelos = ['Continental Flying Spur','Continental GT','Continental GTC','Mulsanne','Bentayga'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $bentley->id
            ]);
        }

        //BMW
        $bmw = Marca::create([
            'nombre' => 'BMW',
        ]);
        $modelos = ['i3','Serie 1','Serie 2','Serie 3','Serie 4','Serie 5','Serie 6','Serie 7','i8','X1','X2','X3','X4','X5','X6'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $bmw->id
            ]);
        }

        //Buick
        $buick = Marca::create([
            'nombre' => 'Buick',
        ]);
        $modelos = ['Encore','Enclave','Lacrosse','Regal','Verano'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $buick->id
            ]);
        }


        //Cadillac
        $cadillac = Marca::create([
            'nombre' => 'Cadillac',
        ]);
        $modelos = ['ATS','CTS','Escalade','XT5','XT4'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $cadillac->id
            ]);
        }


        //Chang'an
        $chang = Marca::create([
            'nombre' => 'Chang\'an',
        ]);
        $modelos = ['Star Light 4500','Q20','Star 3','Minivan','Minitruck'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $chang->id
            ]);
        }

        //Chevrolet
        $chevrolet = Marca::create([
            'nombre' => 'Chevrolet',
        ]);
        $modelos = ['Aveo','Beat','Cavalier','Cruze','Spark','Camaro','Equinox','Malibu','Corvette','Trax','Traverse','Silverado','Tahoe','Suburban','Tornado','Colorado','Volt','Bolt EV'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $chevrolet->id
            ]);
        }

        //Chrysler
        $chrysler = Marca::create([
            'nombre' => 'Chrysler',
        ]);
        $modelos = ['Pacífica','300C'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $chrysler->id
            ]);
        }

        //Dodge
        $dodge = Marca::create([
            'nombre' => 'Dodge',
        ]);
        $modelos = ['Attitude','Vision','Neon','Durango','Challenger','Charger','Journey','Viper'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $dodge->id
            ]);
        }

        //DFSK
        $dfsk = Marca::create([
            'nombre' => 'DFSK',
        ]);
        $modelos = ['Minivan','S1000'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $dfsk->id
            ]);
        }

        //FAW
        $faw = Marca::create([
            'nombre' => 'FAW',
        ]);
        $modelos = ['F1','F4','F5'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $faw->id
            ]);
        }

        //Ferrari
        $ferrari = Marca::create([
            'nombre' => 'Ferrari',
        ]);
        $modelos = ['458 Italia','599 GTB Fiorano','California','FF','LaFerrari','488 GTB','F12 Berlinetta'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $ferrari->id
            ]);
        }

        //Fiat
        $fiat = Marca::create([
            'nombre' => 'Fiat',
        ]);
        $modelos = ['Palio','Uno','California','500','500X','Ducato','500L','Mobi'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $fiat->id
            ]);
        }

        //Ford
        $ford = Marca::create([
            'nombre' => 'Ford',
        ]);
        $modelos = ['Figo','Fiesta','Focus Sedan','Fusion','Ecosport','Escape','Edge','Explorer','Expedition','F-Series','Lobo','Mustang','Ranger','Transit'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $ford->id
            ]);
        }

        //GMC
        $gmc = Marca::create([
            'nombre' => 'GMC',
        ]);
        $modelos = ['Yukon','Sierra','Acadia','Terrain'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $gmc->id
            ]);
        }

        //Honda
        $honda = Marca::create([
            'nombre' => 'Honda',
        ]);
        $modelos = ['Fit','City','Civic','Accord','HR-V','CR-V','Pilot','Odyssey','Ridgeline','BR-V'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $honda->id
            ]);
        }

        //Hyundai
        $hyundai = Marca::create([
            'nombre' => 'Hyundai',
        ]);
        $modelos = ['Grand i10','Elantra','Sonata','Accent','Tucson','Santa Fe','Creta','Ioniq'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $hyundai->id
            ]);

        }


        //Infiniti
        $infiniti = Marca::create([
            'nombre' => 'Infiniti',
        ]);
        $modelos = ['Q50','Q60','Q70','QX60','QX70','QX80'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $infiniti->id
            ]);

        }

        //JAC
        $jac = Marca::create([
            'nombre' => 'JAC',
        ]);
        $modelos = ['SEI 2','SEI 3','J4'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $jac->id
            ]);

        }

        //Jaguar
        $jaguar = Marca::create([
            'nombre' => 'Jaguar',
        ]);
        $modelos = ['XE','XF','F-Type','XJ','XK','F-Pace'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $jaguar->id
            ]);

        }

    //Kia
        $kia = Marca::create([
            'nombre' => 'Kia',
        ]);
        $modelos = ['Forte','Sportage','Sorento','Optima B','Rio','Soul','Niro','Cadenza','Sedona','Stonic','Stinger'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $kia->id
            ]);

        }


    //Jeep
        $jeep = Marca::create([
            'nombre' => 'Jeep',
        ]);
        $modelos = ['Patriot','Compass','Wrangler','Cherokee','Grand Cherokee'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $jeep->id
            ]);

        }

        //Lamborghini
        $lamborhini = Marca::create([
            'nombre' => 'Lamborghini',
        ]);
        $modelos = ['Huracán','Aventator'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $lamborhini->id
            ]);

        }

        //Land Rover
        $landRover = Marca::create([
            'nombre' => 'Land Rover',
        ]);
        $modelos = ['LR4 Discovery','Discovery','Defender','Range Rover','Range Rover Sport','Range Rover Evoque'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $landRover->id
            ]);


        }

        //Lincoln
        $lincoln = Marca::create([
            'nombre' => 'Lincoln',
        ]);
        $modelos = ['MKC','Discovery','MKZ','MKX V','MKS','Navigator SUV'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $lincoln->id
            ]);


        }

        //Lotus
        $lotus = Marca::create([
            'nombre' => 'Lotus',
        ]);
        $modelos = ['Elise','Exige','MKZ','Evora'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $lotus->id
            ]);


        }

        //Maserati
        $maserati = Marca::create([
            'nombre' => 'Maserati',
        ]);
        $modelos = ['Quattroporte','Ghibli','GranTurismo'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $maserati->id
            ]);


        }

        //Mazda
        $maserati = Marca::create([
            'nombre' => 'Mazda',
        ]);
        $modelos = ['Mazda 2','Mazda 3','Mazda 6','CX-3','CX-5','CX-9','MX-5'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $maserati->id
            ]);


        }


        //McLaren
        $mclaren = Marca::create([
            'nombre' => 'McLaren',
        ]);
        $modelos = ['675LT','650S','570S'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $mclaren->id
            ]);
        }


        //Mercedes-Benz
        $mercedes = Marca::create([
            'nombre' => 'Mercedes-Benz',
        ]);
        $modelos = ['Clase A','Clase B','Clase C','Clase E','CLA','Clase CLS','Clase S','Clase SLK','Clase SL','Clase GLA','Clase GLK','Clase M','Clase GL','Clase G','AMG GT','Viano','Vito','Sprinter'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $mercedes->id
            ]);
        }

        //MINI
        $mini = Marca::create([
            'nombre' => 'MINI',
        ]);
        $modelos = ['MINI','MINI Cabrio','Coupé','Roadster','MINI Countryman','MINI Paceman','Clase S','Clase SLK','Clase SL','Clase GLA','Clase GLK','Clase M','Clase GL','Clase G','AMG GT','Viano','Vito','Sprinter'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $mini->id
            ]);
        }

        //Nissan
        $nissan = Marca::create([
            'nombre' => 'Nissan',
        ]);
        $modelos = ['Tsuru','Leaf','March','Tiida','Versa ','Sentra','Altima','Maxima','Note','Kicks','Juke','X-Trail','Pathfinder','Armada','NV350 Urvan','NP300','NT450','370Z','GT-R'];
        foreach ($modelos as $modelo){
            Modelo::create([
                'nombre' => $modelo,
                'marca_id' => $nissan->id
            ]);
        }

//            'Peugeot',
//            'Porsche',
//            'Ram',
//            'Renault',
//            'Rolls-Royce',
//            'SEAT',
//            'Smart',
//            'SRT',
//            'Subaru',
//            'Suzuki',
//            'Tesla',
//            'Toyota',
//            'Volkswagen',
//            'Volvo',
//            'VÜHL',
//        ];
//        foreach ($marcas as $marca){
//            Marca::create([
//                'nombre' => $marca
//            ]);
//        }
    }
}
