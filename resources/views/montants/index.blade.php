@extends('layout.main')

@section('title', 'Liste des montants')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Liste des montants</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ Auth::user()->role }}</a></li>
              <li class="breadcrumb-item active">Liste des montants</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $nombreCommandes ?? 0 }}</h3>
                <p>Total Commandes</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ number_format($totalMontants ?? 0, 0, ',', ' ') }} FCFA</h3>
                <p>Total Montants</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ number_format($totalLivraisons ?? 0, 0, ',', ' ') }} FCFA</h3>
                <p>Total Livraisons</p>
              </div>
              <div class="icon">
                <i class="fas fa-truck"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ number_format(($totalMontants ?? 0) - ($totalLivraisons ?? 0), 0, ',', ' ') }} FCFA</h3>
                <p>Bénéfice Net</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <div class="col-12">
            <div class="text-center mb-4">
              <h2 class="display-4 text-primary font-weight-bold">
                <i class="fas fa-users mr-3"></i>
                Point par client par jour
                <i class="fas fa-calendar-alt ml-3"></i>
              </h2>
              <div class="bg-primary" style="height: 3px; width: 200px; margin: 10px auto; border-radius: 2px;"></div>
              <p class="text-muted lead">Suivi détaillé des montants par service de livraison</p>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-list mr-1"></i>
                  Liste des montants des commandes
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr> 
                      <th>Service Livraison</th>
                      <th>Date de réception</th>
                      <th>Nb Commandes</th>
                      <th>Montant Global</th>
                      <th>Coût Livraison</th>
                      <th>Coût Réel</th>
                      <th>Bénéfice</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($montantsGroupes as $montantGroupe)
                    <tr class="main-row" data-bs-toggle="collapse" data-bs-target="#details-{{ $montantGroupe->group_id }}" style="cursor: pointer;">
                      <td>
                        <i class="fas fa-chevron-right toggle-icon mr-1"></i>
                        <strong>{{ $montantGroupe->delivery_service->nom ?? 'N/A' }}</strong>
                      </td>
                      <td>
                        <strong>{{ \Carbon\Carbon::parse($montantGroupe->date_reception)->format('d/m/Y') }}</strong>
                      </td>
                      <td>
                        <span class="badge badge-info">
                          {{ $montantGroupe->nombre_commandes }}
                        </span>
                      </td>
                      <td>
                        <span class="text-success font-weight-bold">
                          {{ number_format($montantGroupe->total_cout_global, 0, ',', ' ') }} FCFA
                        </span>
                      </td>
                      <td>
                        <span class="text-warning font-weight-bold">
                          {{ number_format($montantGroupe->total_cout_livraison, 0, ',', ' ') }} FCFA
                        </span>
                      </td>
                      <td>
                        <span class="text-info font-weight-bold">
                          {{ number_format($montantGroupe->total_cout_reel, 0, ',', ' ') }} FCFA
                        </span>
                      </td>
                      <td>
                        <span class="font-weight-bold {{ $montantGroupe->benefice >= 0 ? 'text-success' : 'text-danger' }}">
                          {{ number_format($montantGroupe->benefice, 0, ',', ' ') }} FCFA
                        </span>
                      </td>
                    </tr>
                    <!-- Détails des boutiques (collapsible) -->
                    <tr class="collapse" id="details-{{ $montantGroupe->group_id }}">
                      <td colspan="7" class="p-0">
                        <div class="card card-body m-2">
                          <h6 class="text-primary">
                            <i class="fas fa-store mr-2"></i>
                            Détails des boutiques pour {{ $montantGroupe->delivery_service->nom ?? 'N/A' }} - {{ \Carbon\Carbon::parse($montantGroupe->date_reception)->format('d/m/Y') }}
                          </h6>
                          <div class="table-responsive">
                            <table class="table table-sm table-striped">
                              <thead class="thead-light">
                                <tr>
                                  <th>Boutique</th>
                                  <th>Nb Commandes</th>
                                  <th>Montant Global</th>
                                  <th>Coût Livraison</th>
                                  <th>Coût Réel</th>
                                  <th>Bénéfice</th>
                                  <th>Détail Commandes</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($montantGroupe->boutiques_details as $boutiqueDetail)
                                <tr>
                                  <td>
                                    <strong>{{ $boutiqueDetail->boutique->nom_boutique ?? 'N/A' }}</strong>
                                  </td>
                                  <td>
                                    <span class="badge badge-info">{{ $boutiqueDetail->nombre_commandes }}</span>
                                  </td>
                                  <td>
                                    <span class="text-success font-weight-bold">
                                      {{ number_format($boutiqueDetail->total_cout_global, 0, ',', ' ') }} FCFA
                                    </span>
                                  </td>
                                  <td>
                                    <span class="text-warning font-weight-bold">
                                      {{ number_format($boutiqueDetail->total_cout_livraison, 0, ',', ' ') }} FCFA
                                    </span>
                                  </td>
                                  <td>
                                    <span class="text-info font-weight-bold">
                                      {{ number_format($boutiqueDetail->total_cout_reel, 0, ',', ' ') }} FCFA
                                    </span>
                                  </td>
                                  <td>
                                    <span class="font-weight-bold {{ $boutiqueDetail->benefice >= 0 ? 'text-success' : 'text-danger' }}">
                                      {{ number_format($boutiqueDetail->benefice, 0, ',', ' ') }} FCFA
                                    </span>
                                  </td>
                                  <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#commandes-{{ $montantGroupe->group_id }}-{{ $boutiqueDetail->boutique->id }}">
                                      <i class="fas fa-eye"></i> Voir
                                    </button>
                                  </td>
                                </tr>
                                <!-- Détail des commandes par boutique -->
                                <tr class="collapse" id="commandes-{{ $montantGroupe->group_id }}-{{ $boutiqueDetail->boutique->id }}">
                                  <td colspan="7" class="p-2" style="background-color: #f8f9fa;">
                                    <div class="table-responsive">
                                      <table class="table table-sm">
                                        <thead>
                                          <tr>
                                            <th>Code</th>
                                            <th>Communes</th>
                                            <th>Montant Global</th>
                                            <th>Coût Livraison</th>
                                            <th>Coût Réel</th>
                                            <th>Bénéfice</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($boutiqueDetail->commandes as $commande)
                                          <tr>
                                            <td><span class="badge badge-primary">{{ $commande->code ?? 'N/A' }}</span></td>
                                            <td>{{ $commande->communes }}</td>
                                            <td class="text-success">{{ number_format($commande->cout_global, 0, ',', ' ') }} FCFA</td>
                                            <td class="text-warning">{{ number_format($commande->cout_livraison, 0, ',', ' ') }} FCFA</td>
                                            <td class="text-info">{{ number_format($commande->cout_reel, 0, ',', ' ') }} FCFA</td>
                                            <td class="{{ ($commande->cout_global - $commande->cout_livraison) >= 0 ? 'text-success' : 'text-danger' }}">
                                              {{ number_format($commande->cout_global - $commande->cout_livraison, 0, ',', ' ') }} FCFA
                                            </td>
                                          </tr>
                                          @endforeach
                                        </tbody>
                                      </table>
                                    </div>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center">
                        <div class="alert alert-info">
                          <i class="fas fa-info-circle mr-2"></i>
                          Aucune commande enregistrée pour le moment.
                        </div>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Gérer l'animation des icônes de chevron
    $('.main-row').on('click', function() {
        var icon = $(this).find('.toggle-icon');
        var target = $(this).data('bs-target');
        
        // Toggle l'icône
        if ($(target).hasClass('show')) {
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
        } else {
            icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
        }
    });
    
    // Gérer l'état des icônes après l'animation Bootstrap
    $('.collapse').on('shown.bs.collapse', function () {
        var targetId = '#' + $(this).attr('id');
        var row = $('[data-bs-target="' + targetId + '"]');
        row.find('.toggle-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });
    
    $('.collapse').on('hidden.bs.collapse', function () {
        var targetId = '#' + $(this).attr('id');
        var row = $('[data-bs-target="' + targetId + '"]');
        row.find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
    
    // Ajouter un effet hover sur les lignes principales
    $('.main-row').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
});
</script>

<style>
.main-row {
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.main-row:hover {
    background-color: #f8f9fa !important;
}

.toggle-icon {
    transition: transform 0.2s ease;
}

.collapse .card {
    border-left: 4px solid #007bff;
    background-color: #f8f9fa;
}

.table-sm th {
    background-color: #e9ecef;
    font-weight: 600;
}

.text-danger {
    color: #dc3545 !important;
}

.badge {
    font-size: 0.875em;
}

.text-success {
    color: #28a745 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-info {
    color: #17a2b8 !important;
}
</style>

@endsection
