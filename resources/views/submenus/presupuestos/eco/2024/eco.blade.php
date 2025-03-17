<ol class="breadcrumb">
    @can('akumas2023.recepcion') 
    <li @click="$store.state.menuc=106"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
    @endcan
    @can('akumas2023.recepcion') 
    <li @click="$store.state.menuc=107"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
    @endcan
    @can('akumas2023.presupuestos') 
    <li @click="$store.state.menuc=108"><a href="#"><i class="fas fa-list-alt"></i> Anexos Taller</a></li>
    @endcan
    @can('akumas2023.aprobaciones') 
    <li @click="$store.state.menuc=109"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones</a></li>
    @endcan
</ol>