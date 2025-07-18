<template>
  <div class="request-list-container">
    <div class="col-lg-12">
      <!-- Bouton pour démarrer un nouveau trip -->
      <div v-if="requests.length > 0" class="text-center mb-4">
        <a href="/chat" class="btn btn-secondary">
          <i class="fa fa-rocket mr-2"></i>Démarrer un nouvelle trip
        </a>
      </div>

      <!-- Liste des demandes -->
      <div v-for="request in requests" :key="request.id" class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <i class="fa fa-plane mr-2"></i>
              Demande #{{ request.id }}
            </h5>
            <span class="badge badge-dark badge-pill">
              {{ capitalizeFirst(request.status) }}
            </span>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="info-section mb-3">
                <h6 class="text-muted mb-2">
                  <i class="fa fa-euro mr-1"></i>Budget
                </h6>
                <p class="h5 text-success mb-0">
                  {{ formatBudget(request.budget) }}
                </p>
              </div>

              <div class="info-section mb-3">
                <h6 class="text-muted mb-2">
                  <i class="fa fa-calendar mr-1"></i>Dates
                </h6>
                <p class="mb-0">
                  {{ formatDate(request.date_start) }}
                  <i class="fa fa-arrow-right text-muted mx-1"></i>
                  {{ formatDate(request.date_end) }}
                </p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="info-section mb-3">
                <h6 class="text-muted mb-2">
                  <i class="fa fa-globe mr-1"></i>Destination
                </h6>
                <p class="h6 mb-0">{{ request.region || 'Non précisée' }}</p>
              </div>

              <div class="info-section mb-3">
                <h6 class="text-muted mb-2">
                  <i class="fa fa-users mr-1"></i>Voyageurs
                </h6>
                <p class="h6 mb-0">{{ request.people_count || 'Non précisé' }} personne(s)</p>
              </div>
            </div>
          </div>

          <!-- Alerte si aucun festival trouvé -->
          <div v-if="request.status === 'no_festival_found'" class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle mr-2"></i>
            <strong>Information :</strong> Pour le moment, nous n'avons pas de festival prévu à cette
            date. Revenez faire votre demande lorsque cette date est proche.
            <button type="button" class="close" data-dismiss="alert">
              <span>&times;</span>
            </button>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-primary">
              <i class="fa fa-lightbulb-o mr-1"></i>
              <strong>{{ request.proposals ? request.proposals.length : 0 }}</strong> proposition(s)
            </span>

            <span v-if="request.status === 'pending'" class="badge badge-secondary">
              <i class="fa fa-clock-o mr-1"></i>En attente
            </span>
          </div>

          <!-- Indicateur de génération -->
          <div v-if="request.status === 'generating'" class="alert alert-info d-flex align-items-center mt-3">
            <div class="typing-indicator mr-3">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <span><i class="fa fa-cog fa-spin mr-2"></i>L'IA réfléchit à votre demande...</span>
          </div>

          <!-- Propositions -->
          <div v-if="request.proposals && request.proposals.length" class="proposals-container mt-4">
            <h6 class="text-muted mb-3">
              <i class="fa fa-lightbulb-o mr-2"></i>Propositions générées
            </h6>

            <div v-for="proposal in request.proposals" :key="proposal.id" class="proposal-card mb-3">
              <div class="card border-0 shadow-sm">
                <div class="card-header" :class="proposal.status === 'accepted' ? 'bg-success text-white' : 'bg-light'">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                      <i class="fa fa-cog" :class="proposal.status === 'accepted' ? 'text-white' : 'text-primary'" class="mr-2"></i>
                      <strong>Proposition #{{ proposal.id }}</strong>
                    </div>
                    <span class="badge badge-pill" :class="getBadgeClass(proposal.status)">
                      {{ capitalizeFirst(proposal.status) }}
                    </span>
                  </div>
                </div>

                <div class="card-body">
                  <div class="proposal-content mb-3" v-html="formatMarkdown(proposal.response_text)"></div>

                  <div class="price-section text-center p-3 rounded" :class="proposal.status === 'accepted' ? 'bg-success text-white' : 'bg-light'">
                    <h4 class="mb-0 text-lg" :class="proposal.status === 'accepted' ? 'text-white' : 'text-success'">
                      {{ formatPrice(proposal.total_price) }} €
                    </h4>
                    <small :class="proposal.status === 'accepted' ? 'text-white' : 'text-muted'">Prix total TTC</small>
                  </div>

                  <!-- Actions pour les propositions générées -->
                  <div v-if="proposal.status === 'generated'" class="action-buttons mt-3 text-center">
                    <button @click="acceptProposal(proposal.id)" class="btn btn-success mr-2">
                      <i class="fa fa-check mr-1"></i>Accepter et payer
                    </button>

                    <button @click="toggleRefusalForm(proposal.id)" class="btn btn-outline-danger">
                      <i class="fa fa-times mr-1"></i>Refuser
                    </button>

                    <div v-if="showRefusalForm === proposal.id" class="mt-3">
                      <div class="form-group d-flex align-items-stretch">
                        <div class="flex-grow-1 mr-2">
                          <textarea v-model="rejectionReason" class="form-control" rows="3"
                            placeholder="Expliquez pourquoi vous refusez cette proposition... Discutez avec l'IA pour trouver une solution."></textarea>
                        </div>
                        <button @click="rejectProposal(proposal.id)" class="btn btn-primary d-flex align-items-center">
                          Envoyer
                        </button>
                      </div>
                      <small class="text-muted mt-1 d-block">
                        N'envoyez pas vos informations personnelles
                      </small>
                    </div>
                  </div>

                  <!-- Actions pour les propositions acceptées -->
                  <div v-else-if="proposal.status === 'accepted'" class="action-buttons mt-3 text-center">
                    <a :href="`/proposals/${proposal.id}/invoice`" class="btn btn-primary">
                      <i class="fa fa-download mr-1"></i>Télécharger la facture
                    </a>
                  </div>
                </div>
              </div>

              <!-- Message de refus -->
              <div v-if="proposal.status === 'rejected' && proposal.rejection_reason" class="alert alert-warning mt-2">
                <div class="d-flex align-items-start">
                  <div>
                    <p class="mb-0 mt-1">{{ proposal.rejection_reason }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Bulle de génération en cours -->
            <div v-if="request.status === 'generating' || generatingProposals.includes(request.id)" class="alert alert-info d-flex align-items-center">
              <div class="typing-indicator mr-3">
                <span></span>
                <span></span>
                <span></span>
              </div>
              <span><i class="fa fa-cog fa-spin mr-2"></i>L'IA réfléchit à votre demande...</span>
            </div>
          </div>
        </div>
      </div>

      <!-- État vide -->
      <div v-if="requests.length === 0" class="py-5">
        <div class="empty-state">
          <i class="fa fa-plane fa-3x text-muted mb-3"></i>
          <h4>Aucune demande de voyage</h4>
          <p class="text-muted">Vous n'avez pas encore créé de demande de devis.</p>
          <a href="/request/create" class="btn btn-primary">
            <i class="fa fa-plus mr-2"></i>Créer ma première demande
          </a>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination && pagination.last_page > 1" class="d-flex justify-content-left mt-4 p-4">
        <nav>
          <ul class="pagination">
            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
              <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">Précédent</a>
            </li>
            <li v-for="page in getPageNumbers()" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
              <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
              <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)">Suivant</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RequestList',
  data() {
    return {
      requests: [],
      pagination: null,
      rejectionReason: '',
      showRefusalForm: null,
      generatingProposals: [],
      loading: false
    }
  },
  mounted() {
    this.fetchRequests()
    // Polling toutes les 5 secondes
    this.startPolling()
  },
  beforeDestroy() {
    this.stopPolling()
  },
  methods: {
    async fetchRequests(page = 1) {
      try {
        this.loading = true
        const response = await fetch(`/api/requests?page=${page}`)
        const data = await response.json()
        
        this.requests = data.data
        this.pagination = data.meta
      } catch (error) {
        console.error('Erreur lors du chargement des demandes:', error)
      } finally {
        this.loading = false
      }
    },

    startPolling() {
      this.pollingInterval = setInterval(() => {
        this.fetchRequests(this.pagination?.current_page || 1)
      }, 5000)
    },

    stopPolling() {
      if (this.pollingInterval) {
        clearInterval(this.pollingInterval)
      }
    },

    async acceptProposal(proposalId) {
      try {
        const response = await fetch(`/proposals/${proposalId}/accept`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })

        if (response.ok) {
          // Recharger les données
          this.fetchRequests(this.pagination?.current_page || 1)
        } else {
          alert('Erreur lors de l\'acceptation de la proposition')
        }
      } catch (error) {
        console.error('Erreur:', error)
        alert('Erreur lors de l\'acceptation de la proposition')
      }
    },

    async rejectProposal(proposalId) {
      if (!this.rejectionReason.trim()) {
        alert('Veuillez expliquer pourquoi vous refusez cette proposition')
        return
      }

      try {
        const response = await fetch(`/proposals/${proposalId}/reject`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            rejection_reason: this.rejectionReason
          })
        })

        if (response.ok) {
          this.rejectionReason = ''
          this.showRefusalForm = null
          this.fetchRequests(this.pagination?.current_page || 1)
        } else {
          alert('Erreur lors du refus de la proposition')
        }
      } catch (error) {
        console.error('Erreur:', error)
        alert('Erreur lors du refus de la proposition')
      }
    },

    toggleRefusalForm(proposalId) {
      this.showRefusalForm = this.showRefusalForm === proposalId ? null : proposalId
    },

    changePage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchRequests(page)
      }
    },

    getPageNumbers() {
      if (!this.pagination) return []
      
      const pages = []
      const current = this.pagination.current_page
      const last = this.pagination.last_page
      
      for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
        pages.push(i)
      }
      
      return pages
    },

    // Utilitaires
    capitalizeFirst(str) {
      return str.charAt(0).toUpperCase() + str.slice(1)
    },

    formatBudget(budget) {
      return budget ? new Intl.NumberFormat('fr-FR').format(budget) + ' €' : 'Non précisé'
    },

    formatPrice(price) {
      return new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price)
    },

    formatDate(date) {
      if (!date) return '—'
      return new Date(date).toLocaleDateString('fr-FR')
    },

    formatMarkdown(text) {
      // Simple markdown parser pour les éléments de base
      if (!text) return ''
      
      return text
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/\n/g, '<br>')
        .replace(/^- (.*)/gm, '<li>$1</li>')
        .replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>')
    },

    getBadgeClass(status) {
      switch (status) {
        case 'generated':
          return 'badge-secondary'
        case 'accepted':
          return 'badge-success'
        case 'rejected':
          return 'badge-danger'
        default:
          return 'badge-secondary'
      }
    }
  }
}
</script>

<style scoped>
/* Styles généraux */
.info-section {
  padding: 0.75rem;
  border-radius: 0.5rem;
  background-color: #f8f9fa;
}

.proposal-content {
  line-height: 1.6;
}

.proposal-content p {
  margin-bottom: 1rem;
}

.proposal-content ul {
  margin-bottom: 1.5rem;
  padding-left: 1.5rem;
}

.proposal-content li {
  margin-bottom: 0.5rem;
}

.action-buttons {
  border-top: 1px solid #e9ecef;
  padding-top: 1rem;
}

.empty-state {
  max-width: 400px;
  margin: 0 auto;
}

/* Animation de frappe */
.typing-indicator {
  display: flex;
  gap: 4px;
}

.typing-indicator span {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #6c757d;
  animation: typing 1.4s infinite ease-in-out;
}

.typing-indicator span:nth-child(1) {
  animation-delay: -0.32s;
}

.typing-indicator span:nth-child(2) {
  animation-delay: -0.16s;
}

@keyframes typing {
  0%,
  80%,
  100% {
    transform: scale(0.8);
    opacity: 0.5;
  }

  40% {
    transform: scale(1);
    opacity: 1;
  }
}

/* Responsive */
@media (max-width: 768px) {
  .action-buttons .btn {
    display: block;
    width: 100%;
    margin-bottom: 0.5rem;
  }

  .action-buttons .btn:last-child {
    margin-bottom: 0;
  }
}

/* Hover effects */
.proposal-card .card:hover {
  transform: translateY(-2px);
  transition: transform 0.2s ease;
}

.btn:hover {
  transform: translateY(-1px);
  transition: transform 0.1s ease;
}

/* Pagination styles */
.pagination {
  margin-bottom: 0;
}

.page-link {
  color: #007bff;
  background-color: #fff;
  border: 1px solid #dee2e6;
}

.page-item.active .page-link {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
}

.page-item.disabled .page-link {
  color: #6c757d;
  pointer-events: none;
  background-color: #fff;
  border-color: #dee2e6;
}
</style> 