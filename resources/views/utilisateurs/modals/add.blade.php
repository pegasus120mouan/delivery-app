<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="addUserModalLabel">
          <i class="fas fa-user-plus mr-2"></i>Nouvel Utilisateur
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addUserForm" action="{{ route('utilisateurs.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nom" name="nom" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="prenoms" class="form-label">Prénoms <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="prenoms" name="prenoms" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="contact" class="form-label">Contact <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="contact" name="contact" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="whatsapp" class="form-label">WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="lieu_habitation" class="form-label">Lieu d'habitation</label>
            <input type="text" class="form-control" id="lieu_habitation" name="lieu_habitation">
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="role" class="form-label">Rôle <span class="text-danger">*</span></label>
                <select class="form-control" id="role" name="role" required>
                  <option value="">Sélectionner un rôle</option>
                  <option value="admin">Administrateur</option>
                  <option value="client">Client</option>
                  <option value="livreur">Livreur</option>
                  <option value="gerant">Gérant</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="login" class="form-label">Login <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="login" name="login" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirmation du mot de passe <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i> Annuler
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour afficher/masquer le mot de passe
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    }
    
    // Réinitialiser le modal quand il est fermé
    $('#addUserModal').on('hidden.bs.modal', function () {
        document.getElementById('addUserForm').reset();
    });

    // Soumission du formulaire en AJAX
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const formData = form.serialize();
        const url = form.attr('action');
        
        // Validation des mots de passe
        const password = $('#password').val();
        const passwordConfirmation = $('#password_confirmation').val();
        
        if (password !== passwordConfirmation) {
            alert('Les mots de passe ne correspondent pas.');
            $('#password').focus();
            return false;
        }
        
        // Afficher un indicateur de chargement
        const submitButton = form.find('button[type="submit"]');
        const originalText = submitButton.html();
        submitButton.html('<i class="fas fa-spinner fa-spin"></i> Enregistrement...');
        submitButton.prop('disabled', true);
        
        // Envoi AJAX
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Fermer le modal d'ajout
                    $('#addUserModal').modal('hide');
                    
                    // Afficher le modal de succès
                    $('#successMessage').text(response.message);
                    $('#successModal').modal('show');
                    
                    // Recharger la page après 2 secondes
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            },
            error: function(xhr) {
                // Réactiver le bouton
                submitButton.html(originalText);
                submitButton.prop('disabled', false);
                
                // Afficher les erreurs de validation
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Veuillez corriger les erreurs suivantes:\n';
                    
                    for (const field in errors) {
                        errorMessage += `- ${errors[field][0]}\n`;
                    }
                    
                    alert(errorMessage);
                } else {
                    alert('Une erreur est survenue lors de l\'enregistrement.');
                }
            }
        });
    });
    
    // Fermeture du modal de succès
    $('#successModal').on('hidden.bs.modal', function () {
        window.location.reload();
    });
});
</script>