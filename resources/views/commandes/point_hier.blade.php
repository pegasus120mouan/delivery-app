@extends("layout.main")
@section("title", "Point d'hier")
@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Point Général du {{ \Carbon\Carbon::yesterday()->format('d/m/Y') }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Tableau de Bord</a></li>
              <li class="breadcrumb-item active">Point Générale du jour</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Montant Global</span>
                <span class="info-box-number">
                  {{ number_format($montantGlobal, 0, ',', ' ') }} FCFA
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Montant à donner</span>
                <span class="info-box-number">{{ number_format($montantReel, 0, ',', ' ') }} FCFA</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Recette Global</span>
                <span class="info-box-number">{{ number_format($recetteGlobal, 0, ',', ' ') }} FCFA</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Nombre de colis livré aujourd'hui</span>
                <span class="info-box-number">{{ $nombreColisLivres }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Points par Clients</h5>
                  <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                        
                      <tr>
                        <th>Boutiques</th>
                        <th>Montant Global</th>
                        <th>Gain  livraison</th>
                        <th>Versements</th>
                        <th>Nbre de colis Récu</th>
                        <th>Nbre de livré</th>
                        <th>Nbre de colis non Livré</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    <tbody>
                        @foreach($parBoutique as $boutique)
                            <tr>
                                <td>{{ $boutique->nom_boutique }}</td>
                                <td>{{ number_format($boutique->total_amount, 0, ',', ' ') }} FCFA</td>
                                <td>{{ number_format($boutique->total_cout_livraison, 0, ',', ' ') }} FCFA</td>
                                <td>{{ number_format($boutique->total_cout_reel, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $boutique->total_orders }}</td>                      
                                <td>{{ $boutique->total_delivered_orders }}</td>
                                <td>{{ $boutique->total_undelivered_orders }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                    </tbody>
                  </table>
                </div>
              </div>


              <div class="card">
    <div class="card-header bg-primary">
        <h5 class="card-title">Versement</h5>
        <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-bars"></i>
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle table-info">
            <thead>
                <tr>
                    <th style="color: black">Nom du livreur</th>
                    <th style="color: black">Montant Global</th>
                    <th style="color: black">Dépenses</th>
                    <th style="color: black">Gain</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parLivreur as $livreur)
                    <tr>
                        <td style="color: black;">
                            {{ $livreur->livreur }}
                        </td>
                        <td style="color: black;">
                            {{ number_format($livreur->total_cout_livraison, 0, ',', ' ') }} FCFA
                        </td>
                        <td style="color: black;">
                            {{ number_format($livreur->depenses, 0, ',', ' ') }} FCFA
                        </td>
                        <td style="color: black;">
                            {{ number_format($livreur->gain_jour, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
        <!-- /.row -->
        <div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">Point livreur</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Livreur</th>
                        <th>Recette</th>
                        <th>Dépense</th>
                        <th>Gain</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parLivreur as $livreur)
                        <tr>
                            <td>{{ $livreur->livreur }}</td>
                            <td>{{ number_format($livreur->total_cout_livraison, 0, ',', ' ') }} FCFA</td>
                            <td>{{ number_format($livreur->depenses, 0, ',', ' ') }} FCFA</td>
                            <td>{{ number_format($livreur->gain_jour, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.card-body -->
</div>

        <!-- Main row -->

        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
      
    @endsection