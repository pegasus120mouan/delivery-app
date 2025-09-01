@extends("layout.main")
@section("title", "Commandes par service")
@section("content")

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Commandes par service du {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('commandes.point_du_jour') }}">Point du jour</a></li>
              <li class="breadcrumb-item active">Commandes par service</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Commandes par services</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Service de livraison</th>
                    <th>Communes</th>
                    <th>Cout global</th>
                    <th>Cout livraison</th>
                    <th>Cout reel</th>
                    <th>Boutique</th>
                    <th>Livreur</th>
                    <th>Statut</th>
                    <th>Date Reception</th>
                    <th>Date Livraison</th>
                  </tr>
                  </thead>
                  <tbody>

                  @foreach($commandes as $commande)
                  <tr>
                    <td>{{ $commande->deliveryService->nom }}</td>

                    <td>{{ $commande->communes }}</td>
                    <td>{{ $commande->cout_global }}</td>
                    <td>{{ $commande->cout_livraison }}</td>
                    <td>{{ $commande->cout_reel }}</td>
                    <td>{{ $commande->boutique->nom_boutique }}</td>
                    <td>{{ $commande->livreur->nom }} {{ $commande->livreur->prenoms }}</td>
                    <td>{{ $commande->statut }}</td>
                    <td>{{ $commande->date_reception }}</td>
                    <td>{{ $commande->date_livraison }}</td>    
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Service de livraison</th>
                    <th>Communes</th>
                    <th>Cout global</th>
                    <th>Cout livraison</th>
                    <th>Cout reel</th>
                    <th>Boutique</th>
                    <th>Livreur</th>
                    <th>Statut</th>
                    <th>Date Reception</th>
                    <th>Date Livraison</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@endsection
  