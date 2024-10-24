<?php

use Illuminate\Database\Seeder;
use App\Empresa;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [

['id' => 12, 'nombre' => 'CASANOVA RENT VOLKS S.A. DE C.V'                                         , 'rfc' => 'CRV821223DY5' , 'logo' => 'CASANOVA.jpeg' , 'email' => 'vrodriguez@casanovarent.mx'    , 'direccion' => 'AVENIDA PATRIOTISMO No. 735, COLONIA SAN JUAN, CP. 03730 DELEGACION BENITO JUAREZ CIUDAD DE MEXICO TLALNEPANTLA' , 'tel_negocio' => '5555441367'],
['id' => 4, 'nombre' => 'CFE DISTRIBUCION'                                                        , 'rfc' => 'CDI160330RC9' , 'logo' => 'logo_cfe.png'  , 'email' => 'gonzalo.sanchezv@cfe.mx'       , 'direccion' => 'AV. PASEO DE LA REFORMA 164 COL- JUAREZ DEL. CUAUHTEMOC CP 06600'                                                , 'tel_negocio' => '4433140050'],
['id' => 5, 'nombre' => 'ARIZA DE MEXICO S.A. DE C.V.'                                            , 'rfc' => 'AME9511099B8' , 'logo' => 'logo_ariza.png', 'email' => 'revision@proveedores-ariza.com', 'direccion' => 'BLVD. MANUEL AVILA CAMACHO 685 PISO 9 COL. INDUSTRIAL ALCE BLANCO C.P. 53370 NAUCALPAN MEX'                      , 'tel_negocio' => '01551940860'],
['id' => 6, 'nombre' => 'AUTOEXPRESS SERVICIO DE EXCELENCIA'                                      , 'rfc' => 'ASE0508051B6' , 'logo' => 'autoexpress.png', 'email' => 'michoacan@centraldeoperaciones.com','direccion' => 'AV. SAN JERONIMO 220 COL. LA OTRA BANDA CP 04519 COYOACAN', 'tel_negocio'=> '2228713163'],
['id' => 7, 'nombre' => 'CASANOVA RENT S.A. DE C.V.'                                              , 'rfc' => 'CRE970630HJ3' , 'logo' => 'min_CASANOVA.jpeg' ,'email' => ''                               , 'direccion' => 'AV. GUSTAVO BAZ 288 COL. LA LOMA TLALNEPANTLA'            ,'tel_negocio' => '8000227246'],
['id' => 14, 'nombre' => 'PROTECCION DE ALARMAS PRIVADAS S.A. DE C.V.'                             , 'rfc' => 'PAP990622K86' , 'logo' => 'PROTECCION DE ALARMAS.png', 'email' => 'guadalupehernandez@paprisa.com.mx','direccion' => 'RIO CULIACAN 209 PTE. COL. GUADALUPE, C.P. 80220 SINALOA CULIACAN SINALOA', 'tel_negocio' => '44312822633'],
['id' => 26, 'nombre' => 'SERVICIO POSTAL MEXICANO'                                                , 'rfc' => 'SPM860820CF5' , 'logo' => 'logo_correos.png' , 'email' => 'molayo@correosdemexico.gob.mx', 'direccion' => 'AVE. VICENTE GARCIA TORRES NO. 235 COL. EL ROSEDAL DEL. COYOACAN, CIUDAD DE MEXICO C.P. 04330 CDMX', 'tel_negocio' => '4433356297'],
['id' => 30, 'nombre' => 'ELEMENT FLEET MANAGEMENT CORPORATION MEXICO SA DE CV'                    , 'rfc' => 'EFM150724B12' , 'logo' => 'logo_element.png' , 'email' => 'akumas@icloud.com', 'direccion' => 'AVENIDA VASCO DE QUIROGA 3000 PLANTA BAJA  CENTRO DE SANTA FE DEL  ALVARO OBREGON CP 01210 MEXICO DF CDMX', 'tel_negocio' => '018007165205'],
['id' => 34, 'nombre' => 'FEDEX DE MEXICO S DE RL DE CV'                                           , 'rfc' => 'FDM9911259E3' , 'logo' => 'logo_fedex.png' , 'email' => 'cperez@fedex.com', 'direccion' =>   'VASCO DE QUIROGA 2999 1ER. PISO COL. SANTA FE PEÃ‘A BLANCA DEL. ALVARO OBREGON C.P. 01210 CIUDAD DE MEXICO', 'tel_negocio' => '7226008879'],
['id' => 38, 'nombre' => 'HESCA ENVIRONMENTAL SERVICES DE MEXICO SA DE CV'                         , 'rfc' => 'HES151029GI5' , 'logo' => 'HESCA.jpg' , 'email' => 'recepcionhesca@hescaing.com',  'direccion' => 'CARRETERA FEDERAL LIBRE SALAMANCA - CELAYA KM 81 EDIFICIO B,  CP 38271, VILLAGRAN, GTO. MEXICANOS VILLAGRAN GUANAJUATO', 'tel_negocio' => '4611719968'],
['id' => 328, 'nombre' => 'LILY GWENDOLYNE RAMIREZ TORRES'                                          , 'rfc' => 'RATL900106HY9', 'logo' => '' , 'email' => 'difjimenez2018@autlook.com', 'direccion' => 'CALLE 1Â° DE MAYO 53 PTE. VILLA JIMENEZ MICHOACAN  MUNICIPIO DE VILLA JIMENEZ, MICHOACAN', 'tel_negocio' => ''],
['id' => 55, 'nombre' => 'PROCURADURIA GENERAL DE LA REPUBLICA'                                    , 'rfc' => 'PGR850101RC6' , 'logo' => 'logo_pgr.jpg' , 'email' => 'mariaclara.rangel@pgr.gob.mx', 'direccion' =>   'AVENIDA PASEO DE LA REPUBLICA 211-213 COL. CUAUHTEMOC CP 06500, MEXICO, DF', 'tel_negocio' => '4433651466'],
['id' => 321, 'nombre' => 'SECRETARIA DE BIENESTAR DELEGACION MICHOACAN'                            , 'rfc' => 'SDS920522F6A' , 'logo' => 'bienestar.jpg' , 'email' => 'edgar.montero@bienestar.gob.mx', 'direccion' =>   'SANTOS DEGOLLADO No. 262 COLONIA NUEVA CHAPULTEPEC 58260 MORELIA, MICHOACAN', 'tel_negocio' => ''],
['id' => 60, 'nombre' => 'SECRETARIA DE DESARROLLO SOCIAL DELEGACION MICHOACAN'                    , 'rfc' => 'XXXXXXXXXXXX' , 'logo' => 'SEDESOL.png' , 'email' => 'jesusoregel@hotmail.com', 'direccion' =>   'SANTOS DEGOLLADO 262 COL. CHAPULTEPEC SUR','tel_negocio' => '5519487108'],
['id' => 62, 'nombre' => 'SMARTLEASE SA DE CV'                                                     , 'rfc' => 'SMA140304DL4' , 'logo' => 'smartlease.png' , 'email' => 'f.calixto@smartlease.mx', 'direccion' =>   'AV. JOSE LOPEZ PORTILLO 139, SAN MATEO CUAUTEPEC, TULTITLAN, CD. DE MEXICO CP 54948 TULTITLAN MEXICO','tel_negocio' => '5519487108'],
['id' => 63, 'nombre' => 'CFE SUMINISTRADOR DE SERVICIOS BASICOS  '                                , 'rfc' => 'CSS160330CP7',  'logo' => 'CFE SUMINISTRO.png' , 'email' => 'tallerakumas@hotmail.com', 'direccion' =>  'AV. PASEO DE LA REFORMA 164 COL. JUAREZ, DELEGACION CUAUTHETMOC, C.P. 06600 CDMX', 'tel_negocio' => '4433220050'],
['id' => 65, 'nombre' => 'UNIVERSIDAD MICHOACANA DE SAN NICOLAS DE HIDALGO'                        , 'rfc' => 'UMS300101KE8' , 'logo' => 'UMSNH.jpeg' , 'email' => 'serviciosgf@hotmail.com', 'direccion' =>   'SANTIAGO TAPIA 403, COL. CENTRO, C.P. 58000 MORELIA, MICH. MORELIA MICHOACAN', 'tel_negocio' => '4431550589'],
['id' => 309, 'nombre' => 'SECRETARIA DE AGRICULTURA GANADERIA DESARROLLO RURAL PESCA Y ALIMENTACION','rfc' => 'SAG051104M5A',  'logo' => 'logo_sagarpa.png' , 'email' => 'tallerakumas@hotmail.com', 'direccion' =>   'AVENIDA VENTURA PUENTE NO. 359 COL. CHAPULTEPEC NORTE, MORELIA, MICH. C.P. 58260', 'tel_negocio' => '4433285228'],
['id' => 93, 'nombre' => 'CASANOVA VALLEJO S.A. DE C.V.'                                            ,'rfc' => 'CVA910402GI5',  'logo' => 'CASANOVA.jpeg' , 'email' => 'autorizacioneslaviga@casanovarent.com.mx', 'direccion' =>   'CALLE NORTE 45 No. 940, INT C  COLONIA INDUSTRIAL VALLEJO, AZCAPOTZALCO, LA LOMA ESTADO DE MEXICO', 'tel_negocio' => '5555441367'],
['id' => 310, 'nombre' => 'INTEGRA ARRENDA SA DE CV SOFOM ENR'                                       ,'rfc' => 'XXXXXXXXXXXX',  'logo' => 'logo_integra.png' , 'email' => 'pablohernandez@lumofleet.com ', 'direccion' => 'Av. San Jerónimo 424 Int. 201, Col. Jardines del Pedregal, Del. Álvaro Obregón,  C.P. 01900   México D.F.', 'tel_negocio' => '5555441367'],
['id' => 311, 'nombre' => 'LEASE AND FLEET SOLUTIONS SA DE CV'                                       ,'rfc' => 'LFS161207DP3',  'logo' => 'lumo.png' , 'email' => 'pablohernandez@lumofleet.com ', 'direccion' => 'C. FRANCISCO BARRERA NO. 11 AMPLIACION PROFR. CRISTOBAL HIGUERA, ATIZAPAN DE ZARAGOZA, MEXICO D.F. C.P. 52940', 'tel_negocio' => '5543181628'],
['id' => 316, 'nombre' => 'TUM TRANSPORTISTAS UNIDOS MEXICANOS DIVISION NORTE SA DE CV'              ,'rfc' => 'TTU971007DM2',  'logo' => 'logo_tum.png' , 'email' => '', 'direccion' => 'CALLE EUCALIPTO No. 2 COL. FRACCIONAMIENTO INDUSTRIAL TABLA HONDA MUNICIPIO TLALNEPANTLA DE BAZ, ESTADO DE MEXICO', 'tel_negocio' => ''],
['id' => 317, 'nombre' => 'MARLEN ZAVALA '                                                           ,'rfc' => 'TTU971007DM2',  'logo' => 'autoexpress.png' , 'email' => '', 'direccion' => '', 'tel_negocio' => '44335844254'],
['id' => 318, 'nombre' => 'GERARDO PONCE DE LEON FELIX'                                              ,'rfc' => 'POFG511104973', 'logo' => '' , 'email' => 'gerardopdelf@hotmail.com', 'direccion' => 'CORREGIDORA 364 -A INTERIOR 3 COL. CENTRO MORELIA, MICHOACAN C.P. 58000', 'tel_negocio' => ''],
['id' => 319, 'nombre' => 'DISTRIBUIDORA DE EQUIPO Y SERVICIO GONZALEZ SA DE CV'                     ,'rfc' => 'DES821012CPA',  'logo' => 'desego.jfif' , 'email' => '', 'direccion' =>   'FUENTE DE LA RANA # 58 COLONIA FUENTES DE MORELIA C.P. 58080 MORELIA, MICHOACAN', 'tel_negocio' => '2330303'],
['id' => 320, 'nombre' => 'JUAN VASCO ARTURO MATEOS ESTRADA'                                         ,'rfc' => 'MAEJ610608H47', 'logo' => '' , 'email' => 'mateos_arturo@hotmail.com', 'direccion' =>   'ANDALUCITA 155 FRACCIONAMIENTO VILLAS DEL PEDREGAL 58330 MORELIA, MICHOACAN', 'tel_negocio' => ''],
['id' => 322, 'nombre' => 'OCTAVIANO JUAREZ GUERRERO'                                                ,'rfc' => 'JUGO290963',    'logo' => 'ARIZA.png' , 'email' => 'jugo635@hotmail.com', 'direccion' =>   'ZURUMUTARO NO. 358 COL. TINIJARO C.P. 53883', 'tel_negocio' => '4433182560'],
['id' => 324, 'nombre' => 'FELIPE AYALA GARCIA'                                                      ,'rfc' => 'AAGF760131JJ7', 'logo' => '' , 'email' => 'construmetalicas.ayala@gmail.com', 'direccion' =>   'RINCON DE LAS MAGNOLIAS 35 LOMAS DE LA AURORA C.P. 58337 MORELIA, MICHOACAN', 'tel_negocio' => ''],
['id' => 323, 'nombre' => 'MATERIALES EL GIGANTE'                                                    ,'rfc' => 'CASO750722F38', 'logo' => '' , 'email' => '', 'direccion' =>   'SITIO DE CUAUTLA 607-A COL. NIÃ‘O ARTILLERO C.P. 58337 MORELIA, MICHOACAN', 'tel_negocio' => '334 26 68'],
['id' => 315, 'nombre' => 'CASANOVA CHAPULTEPEC S.A. DE C.V.'                                        ,'rfc' => 'CCA870615FV0',  'logo' => '' , 'email' => 'vrodriguez@casanovarent.mx', 'direccion' =>   'AVENIDA CHAPULTEPEC 442, COL ROMA, C.P. 06700, DELEGACION CUAUHTEMOC, CIUDAD DE MEXICO', 'tel_negocio' => '5554825275'],
['id' => 312, 'nombre' => 'COMISION NACIONAL DE ACUACULTURA Y PESCA'                                 ,'rfc' => 'CNA010605Q50',  'logo' => 'conapesca.png' , 'email' => 'fermin.martinez@conapesca.gob.mx', 'direccion' =>   'AVE. CAMARON SABALO NO. 1210 FRACC. SABALO COUNTRY CLUB CP 82100 MAZATLAN, SIN.', 'tel_negocio' => '6699156900'],
['id' => 313, 'nombre' => 'CFE GENERACION VI'                                                        ,'rfc' => 'CGV160330JS5',  'logo' => 'CFE GENERACION VI.jpeg' , 'email' => 'delia.quintana@cfe.gob.mx', 'direccion' => 'AVE. PASEO DE LA REFORMA NO. 164 COL. JUAREZ, DEL. CUAUHTEMOC C.P. 06000, MEXICO, D.F.', 'tel_negocio' => '4433227011'],
['id' => 325, 'nombre' => 'VICTOR MANUEL AGUIRRE GALLEGOS'                                           ,'rfc' => 'XXXXXXXXXXXX',  'logo' => '' , 'email' => '', 'direccion' => 'MORELIA,MICH', 'tel_negocio' => '4433227011'],
['id' => 326, 'nombre' => 'ARTURO SORIA'                                    ,'rfc' => 'XXXXXXXXXXXX',  'logo' => '' , 'email' => '', 'direccion' => 'MORELIA,MICH', 'tel_negocio' => ''],
['id' => 327, 'nombre' => 'LEYVA'                                           ,'rfc' => 'XXXXXXXXXXXX',  'logo' => '' , 'email' => '', 'direccion' => 'MORELIA,MICH', 'tel_negocio' => '']

        ];

        foreach($datos as $dato){
            Empresa::create($dato);
        }
    }
}
