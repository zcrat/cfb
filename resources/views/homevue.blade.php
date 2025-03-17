@extends ('layouts.admin')
@section ('contenido')

<template v-if="$store.state.menuc==0">

                <dashboard-component></dashboard-component>

</template>

<template v-if="$store.state.menuc==1">
                <articulo-component></articulos-component>
</template>

<template v-if="$store.state.menuc==2">
                <categoria-component></categorias-component>
</template>

<template v-if="$store.state.menuc==3">

                <empresa-component></empresa-component>

</template>

<template v-if="$store.state.menuc==4">

                <ingreso-component></ingreso-component>

</template>

<template v-if="$store.state.menuc==5">

                <proveedor-component></proveedor-component>

</template>

<template v-if="$store.state.menuc==6">

                <venta-component></venta-component>

</template>

<template v-if="$store.state.menuc==7">

                <cliente-component></cliente-component>

</template>
<template v-if="$store.state.menuc==8">

                <usuario-component></usuario-component>

</template>
<template v-if="$store.state.menuc==9">

                <rol-component></rol-component>

</template>
<template v-if="$store.state.menuc==10">

                <cingreso-component></rol-component>

</template>
<template v-if="$store.state.menuc==11">

                <cventa-component></cventa-component>

</template>

<template v-if="$store.state.menuc==12">

                <customer-component></customer-component>

</template>

<template v-if="$store.state.menuc==13">

                <recepcion-vehicular-component></recepcion-vehicular-component>

</template>

<template v-if="$store.state.menuc==14">

                <cotizacion-component></cotizacion-component>

</template>


<template v-if="$store.state.menuc==15">

                <facturacion-component></facturacion-component>

</template>


<template v-if="$store.state.menuc==16">

                <config-factura-component></config-factura-component>

</template>


<template v-if="$store.state.menuc==17">

                <reporte-inspeccion-component></reporte-inspeccion-component>

</template>

<template v-if="$store.state.menuc==18">

                <hoja-de-conceptos-component></hoja-de-conceptos-component>

</template>

<template v-if="$store.state.menuc==19">

                <reporte-grua-component></reporte-grua-component>

</template>

<template v-if="$store.state.menuc==20">

                <orden-compra-component></orden-compra-component>

</template>

<template v-if="$store.state.menuc==21">

                <orden-reparacion-component></orden-reparacion-component>

</template>

<template v-if="$store.state.menuc==22">

                <asgnar-tecnico-recepcion></asgnar-tecnico-recepcion>

</template>

<template v-if="$store.state.menuc==23">

                <mi-recepciones></mi-recepciones>

</template>

<template v-if="$store.state.menuc==24">

                <sucursales-component></sucursales-component>

</template>

<template v-if="$store.state.menuc==25">

                <cotizacion2021-component></cotizacion2021-component>

</template>

<template v-if="$store.state.menuc==26">

                <productos-grupos-component></productos-grupos-component>

</template>

<template v-if="$store.state.menuc==27">

                <bancos-component></bancos-component>

</template>

<template v-if="$store.state.menuc==28">

                <cuentas-component></cuentas-component>

</template>

<template v-if="$store.state.menuc==29">

                <operaciones-caja-component></operaciones-caja-component>

</template>

<template v-if="$store.state.menuc==30">

                <presupuesto-component></presupuesto-component>

</template>

<template v-if="$store.state.menuc==31">

                <ordenes-component></ordenes-component>

</template>

<template v-if="$store.state.menuc==32">

                <aprobaciones-taller-component></aprobaciones-taller-component>

</template>

<template v-if="$store.state.menuc==33">

                <aprobaciones-cfe-component></aprobaciones-cfe-component>

</template>


<template v-if="$store.state.menuc==34">

                <presupuestos-akumas-component></presupuestos-akumas-component>

</template>


<template v-if="$store.state.menuc==35">

                <aprobaciones-akumas-component></aprobaciones-akumas-component>

</template>


<template v-if="$store.state.menuc==36">

                <reportes-akumas-component></reportes-akumas-component>

</template>

<template v-if="$store.state.menuc==37">
            <contratos-component></contratos-component>
</template>

<template v-if="$store.state.menuc==38">
            <cuentasporcobrar-component></cuentasporcobrar-component>
</template>

<template v-if="$store.state.menuc==39">
        <inicio-cfe-component></inicio-cfe-component>
</template>

<template v-if="$store.state.menuc==40">
        <inicio-akumas-component></inicio-akumas-component>
</template>

<template v-if="$store.state.menuc==41">

                <aprobaciones-cfe2-component></aprobaciones-cfe2-component>

</template>

<template v-if="$store.state.menuc==42">

                <ubicaciones-component></ubicaciones-component>

</template>

<template v-if="$store.state.menuc==43">

                <areas-component></areas-component>

</template>

<template v-if="$store.state.menuc==44">

                <categorias-cfe-component></categorias-cfe-component>

</template>

<template v-if="$store.state.menuc==45">

                <categorias-akumas-component></categorias-akumas-component>

</template>

<template v-if="$store.state.menuc==46">

                <tipos-cfe-component></tipos-cfe-component>

</template>

<template v-if="$store.state.menuc==47">

                <tipos-akumas-component></tipos-akumas-component>

</template>

<template v-if="$store.state.menuc==48">

                <conceptos-cfe-component></conceptos-cfe-component>

</template>

<template v-if="$store.state.menuc==49">

                <conceptos-akumas-component></conceptos-akumas-component>

</template>

<template v-if="$store.state.menuc==50">

                <operaciones-bancos-component></operaciones-bancos-component>

</template>

<template v-if="$store.state.menuc==51">

                <saldos-component></saldos-component>

</template>

<template v-if="$store.state.menuc==52">

                <facturas-contrato-component></facturas-contrato-component>

</template>









<template v-if="$store.state.menuc==53">

                <ordenesb2023-component></ordenesb2023-component>

</template>
<template v-if="$store.state.menuc==54">

                <presupuestob2023-component></presupuestob2023-component>

</template>
<template v-if="$store.state.menuc==55">

                <aprobaciones-tallerb2023-component></aprobaciones-tallerb2023-component>

</template>
<template v-if="$store.state.menuc==56">

                <aprobaciones-cfeb2023-component></aprobaciones-cfeb2023-component>

</template>
<template v-if="$store.state.menuc==57">

                <aprobaciones-cfe2b2023-component></aprobaciones-cfe2b2023-component>
</template>
<template v-if="$store.state.menuc==58">

                <inicio-cfeb2023-component></inicio-cfeb2023-component>

</template>
<template v-if="$store.state.menuc==59">

                <cventab2023-component></cventab2023-component>

</template>






<template v-if="$store.state.menuc==60">

                <ordeneso2023-component></ordeneso2023-component>

</template>
<template v-if="$store.state.menuc==61">

                <presupuestoo2023-component></presupuestoo2023-component>

</template>
<template v-if="$store.state.menuc==62">

                <aprobaciones-tallero2023-component></aprobaciones-tallero2023-component>

</template>
<template v-if="$store.state.menuc==63">

                <aprobaciones-cfeo2023-component></aprobaciones-cfeo2023-component>

</template>
<template v-if="$store.state.menuc==64">

                <aprobaciones-cfe2o2023-component></aprobaciones-cfe2o2023-component>
</template>
<template v-if="$store.state.menuc==65">

                <inicio-cfeo2023-component></inicio-cfeo2023-component>

</template>
<template v-if="$store.state.menuc==66">

                <cventao2023-component></cventao2023-component>

</template>

<template v-if="$store.state.menuc==67">

                <tareas-component></tareas-component>

</template>

<template v-if="$store.state.menuc==68">

                <tareas-admin-component></tareas-admin-component>

</template>

<template v-if="$store.state.menuc==69">

                <presupuestos-akumas2023-component></presupuestos-akumas2023-component>

</template>


<template v-if="$store.state.menuc==70">

        <aprobaciones-akumas2023-component></aprobaciones-akumas2023-component>
</template>

<template v-if="$store.state.menuc==71">
        <reportes-akumas2023-component></reportes-akumas2023-component>
</template>

<template v-if="$store.state.menuc==72">
        <inicio-akumas2023-component></inicio-akumas2023-component>
</template>

<template v-if="$store.state.menuc==73">
        <tecnicos-component></tecnicos-component>
</template>

<template v-if="$store.state.menuc==74">
        <trasladistas-component></trasladistas-component>
</template>

<template v-if="$store.state.menuc==75">
        <vehiculos-component></vehiculos-component>
</template>


<template v-if="$store.state.menuc==76">
        <tareaseje-component></tareaseje-component>
</template>

<template v-if="$store.state.menuc==77">

                <conceptos-akumas2023-component></conceptos-akumas2023-component>

</template>

<template v-if="$store.state.menuc==78">
                <recepcion-vehicular-bajio2022></recepcion-vehicular-bajio2022>
</template>
<template v-if="$store.state.menuc==79">
                <recepcion-vehicular-bajio2023></recepcion-vehicular-bajio2023>
</template>
<template v-if="$store.state.menuc==80">
                <recepcion-vehicular-occidente2023></recepcion-vehicular-occidente2023>
</template>
<template v-if="$store.state.menuc==81">
                <recepcion-vehicular-akumas></recepcion-vehicular-akumas>
</template>
<template v-if="$store.state.menuc==82">
                <recepcion-vehicular-akumas2023></recepcion-vehicular-akumas2023>
</template>

<template v-if="$store.state.menuc==83">
        <entradas-salidas-component></entradas-salidas-component>
</template>

<template v-if="$store.state.menuc==84">
        <ordenes-pagadas-component></ordenes-pagadas-component>
</template>



<template v-if="$store.state.menuc==85">
        <ordenes-foraneas-component></ordenes-foraneas-component>
</template>


<template v-if="$store.state.menuc==86">
        <es-foraneas-component></es-foraneas-component>
</template>



<template v-if="$store.state.menuc==87">
        <acuse-foraneos-component></acuse-foraneos-component>
</template>

<template v-if="$store.state.menuc==88">
        <anexos-foraneos-component></anexos-foraneos-component>
</template>

<template v-if="$store.state.menuc==89">
        <aprobaciones-foraneos-component></aprobaciones-foraneos-component>
</template>

<template v-if="$store.state.menuc==90">
        <start-foraneos-component></start-foraneos-component>
</template>

<template v-if="$store.state.menuc==91">
        <reportes-foraneos-component></reportes-foraneos-component>
</template>


<template v-if="$store.state.menuc==92">
        <conceptos-foraneos-component></conceptos-foraneos-component>
</template>


<template v-if="$store.state.menuc==93">
        <categorias-foraneos-component></categorias-foraneos-component>
</template>


<template v-if="$store.state.menuc==94">
        <tipos-foraneos-component></tipos-foraneos-component>
</template>


<template v-if="$store.state.menuc==95">
        <hoja-conceptos-akumas-2023-component></hoja-conceptos-akumas-2023-component>
</template>


<template v-if="$store.state.menuc==96">
        <hoja-conceptos-akumas-component></hoja-conceptos-akumas-component>
</template>

<template v-if="$store.state.menuc==97">
        <hoja-conceptos-occidente-2023-component></hoja-conceptos-occidente-2023-component>
</template>

<template v-if="$store.state.menuc==98">
        <hoja-conceptos-bajio-2023-component></hoja-conceptos-bajio-2023-component>
</template>

<template v-if="$store.state.menuc==99">

        <tipos-akumas2024-component></tipos-akumas2024-component>

</template>

<template v-if="$store.state.menuc==100">

        <categorias-akumas2024-component></categorias-akumas2024-component>

</template>



<template v-if="$store.state.menuc==101">

        <recepcion-cfe-eco></recepcion-cfe-eco>

</template>


<template v-if="$store.state.menuc==102">

        <hoja-conceptos-cfe-eco-component></hoja-conceptos-cfe-eco-component>

</template>

<template v-if="$store.state.menuc==103">

        <ordenes-cfe-eco-component></ordenes-cfe-eco-component>

</template>


<template v-if="$store.state.menuc==104">

        <presupuestoo-cfe-eco-component></presupuestoo-cfe-eco-component>

</template>

<template v-if="$store.state.menuc==105">

        <aprobaciones-taller-cfe-eco-component></aprobaciones-taller-cfe-eco-component>

</template>





<template v-if="$store.state.menuc==106">

        <recepcion-akumas-eco></recepcion-akumas-eco>

</template>


<template v-if="$store.state.menuc==107">

        <hoja-conceptos-akumas-eco-component></hoja-conceptos-akumas-eco-component>

</template>



<template v-if="$store.state.menuc==108">

        <ordenes-akumas-eco-component></ordenes-akumas-eco-component>

</template>

<template v-if="$store.state.menuc==109">

        <aprobaciones-taller-akumas-eco-component></aprobaciones-taller-akumas-eco-component>

</template>





<template v-if="$store.state.menuc==110">
        <acuse-foraneos-eco-component></acuse-foraneos-eco-component>
</template>

<template v-if="$store.state.menuc==111">
        <anexos-foraneos-eco-component></anexos-foraneos-eco-component>
</template>

<template v-if="$store.state.menuc==112">
        <aprobaciones-foraneos-eco-component></aprobaciones-foraneos-eco-component>
</template>

<template v-if="$store.state.menuc==113">
        <start-foraneos-eco-component></start-foraneos-eco-component>
</template>

<template v-if="$store.state.menuc==114">
        <reportes-foraneos-eco-component></reportes-foraneos-eco-component>
</template>


<template v-if="$store.state.menuc==115">

        <recepcion-akumas-eco-en></recepcion-akumas-eco-en>

</template>


<template v-if="$store.state.menuc==116">

        <hoja-conceptos-akumas-eco-en-component></hoja-conceptos-akumas-eco-en-component>

</template>



<template v-if="$store.state.menuc==117">

        <ordenes-akumas-eco-en-component></ordenes-akumas-eco-en-component>

</template>

<template v-if="$store.state.menuc==118">

        <aprobaciones-taller-akumas-eco-en-component></aprobaciones-taller-akumas-eco-en-component>

</template>






      
         
@endsection