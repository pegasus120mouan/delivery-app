@extends("layout.main")
@section("title", "Gestion des utilisateurs")
@section("content")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile de {{ $utilisateur->nom }} {{ $utilisateur->prenoms }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Modifications de  Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('storage/utilisateurs/' . $utilisateur->avatar) }}"
                       alt="User profile picture">
                </div>
                <form action="{{ route('utilisateurs.update-avatar', $utilisateur) }}" method="POST" enctype="multipart/form-data">                @csrf
                @method('PUT')
                <input type="file" name="avatar" id="avatar">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

                <h3 class="profile-username text-center">{{ $utilisateur->nom }} {{ $utilisateur->prenoms }}</h3>

                <p class="text-center {{ $utilisateur->lieu_habitation ? 'text-muted' : 'text-danger' }}">
                        {{ $utilisateur->lieu_habitation ?? 'Lieu d\'habitation non renseigné' }}
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Nom</b> <a class="float-right">{{ $utilisateur->nom }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Prénoms</b> <a class="float-right">{{ $utilisateur->prenoms }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Contact</b> <a class="float-right">{{ $utilisateur->contact }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Whatsapp</b> <a class="float-right">{{ $utilisateur->whatsapp }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>E-mail</b> <a class="float-right">{{ $utilisateur->email }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Role</b> <a class="float-right">{{ $utilisateur->role }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Login</b> <a class="float-right">{{ $utilisateur->login }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Date de création</b> <a class="float-right">{{ $utilisateur->created_at->format('d/m/Y') }}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#editInfo" data-toggle="tab">Modifier mes informations</a></li>
                  <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Changer mon mot de passe</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="editInfo">
                  <div class="tab-pane" id="settings">
                  <form class="form-horizontal" action="{{ route('utilisateurs.update', $utilisateur->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                          <input type="text" name="nom" value="{{ $utilisateur->nom }}" class="form-control" id="inputName" placeholder="nom">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Prénoms</label>
                        <div class="col-sm-10">
                          <input type="text" name="prenoms" value="{{ $utilisateur->prenoms }}" class="form-control" id="inputEmail" placeholder="Prénoms">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Contact</label>
                        <div class="col-sm-10">
                          <input type="text" name="contact" value="{{ $utilisateur->contact }}" class="form-control" id="inputName2" placeholder="Contact">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">WhatsApp</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="whatsapp" value="{{ $utilisateur->whatsapp }}" id="inputExperience" placeholder="WhatsApp">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" value="{{ $utilisateur->email }}" id="inputSkills" placeholder="E-mail">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Lieu d'habitation</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="lieu_habitation" value="{{ $utilisateur->lieu_habitation }}" id="inputSkills" placeholder="Lieu d'habitation">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-large btn-success">Modifier les informations</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="changePassword">
                    <!-- The timeline -->

                    <form action="{{ route('utilisateurs.change-password', $utilisateur) }}" method="POST">
                      @csrf
                      <div class="form-group row">
                        <label for="ancien_password" class="col-sm-2 col-form-label">Ancien mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="ancien_password" id="ancien_password" class="form-control @error('ancien_password') is-invalid @enderror" placeholder="Veuillez entrer votre ancien mot de passe" required>
                          @error('ancien_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nouveau_password" class="col-sm-2 col-form-label">Nouveau mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="nouveau_password" id="nouveau_password" class="form-control @error('nouveau_password') is-invalid @enderror" placeholder="Veuillez entrer votre nouveau mot de passe" required>
                          @error('nouveau_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="confirmer_nouveau_password" class="col-sm-2 col-form-label">Confirmer le mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="confirmer_nouveau_password" id="confirmer_nouveau_password" class="form-control @error('confirmer_nouveau_password') is-invalid @enderror" placeholder="Veuillez confirmer votre nouveau mot de passe" required>
                          @error('confirmer_nouveau_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-large btn-danger">Modifier mon mot de passe</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Ancien mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="ancien_password" class="form-control" id="inputName" placeholder="Ancien mot de passe">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">ENmail</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
