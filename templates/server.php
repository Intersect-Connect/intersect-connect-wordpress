<div id="dashboard-widgets-wrap">
    <div id="dashboard-widgets" class="metabox-holder">
        <div id="postbox-container-1" class="postbox-container">
            <div id="normal-sortables" class="">
                <!-- Etat du serveur -->
                <div id="dashboard_site_health" class="postbox">
                    <div class="postbox-header">
                        <h2 class="hndle">État du serveur</h2>
                    </div>
                    <div class="inside">
                        <div class="health-check-widget">
                            <div class="health-check-widget-title-section site-health-progress-wrapper loading hide-if-no-js">
                                <div class="site-health-progress-label">
                                    Aucune information pour le moment…
                                </div>
                            </div>

                            <div class="site-health-details">
                                <p>
                                    Des contrôles de santé du site seront automatiquement effectués périodiquement pour recueillir des informations sur votre site. Vous pouvez également vous rendre sur <a href="http://intersect-test.test/wp-admin/site-health.php">l’écran de Santé du site</a> pour recueillir dès maintenant des informations sur votre site.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Etat du serveur -->
            </div>
        </div>
        <div id="postbox-container-2" class="postbox-container">
            <div id="side-sortables" class="meta-box-sortables">
                <div id="dashboard_primary" class="postbox ">
                    <div class="postbox-header">
                        <h2 class="hndle">Évènements et nouveautés WordPress</h2>
                        <div class="handle-actions hide-if-no-js"><button type="button" class="handle-order-higher" aria-disabled="false" aria-describedby="dashboard_primary-handle-order-higher-description"><span class="screen-reader-text">Monter</span><span class="order-higher-indicator" aria-hidden="true"></span></button><span class="hidden" id="dashboard_primary-handle-order-higher-description">Déplacer la boite Évènements et nouveautés WordPress vers le haut</span><button type="button" class="handle-order-lower" aria-disabled="false" aria-describedby="dashboard_primary-handle-order-lower-description"><span class="screen-reader-text">Descendre</span><span class="order-lower-indicator" aria-hidden="true"></span></button><span class="hidden" id="dashboard_primary-handle-order-lower-description">Déplacer la boite Évènements et nouveautés WordPress vers le bas</span><button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Ouvrir/fermer la section Évènements et nouveautés WordPress</span><span class="toggle-indicator" aria-hidden="true"></span></button></div>
                    </div>
                    <div class="inside">
                        <div class="community-events-errors notice notice-error inline" aria-hidden="true">
                            <p class="hide-if-js">
                                Ce widget nécessite JavaScript. </p>

                            <p class="community-events-error-occurred" aria-hidden="true">
                                Une erreur est survenue. Veuillez essayer à nouveau. </p>

                            <p class="community-events-could-not-locate" aria-hidden="true"></p>
                        </div>

                        <div class="community-events-loading hide-if-no-js" aria-hidden="true">
                            Chargement… </div>

                        <div id="community-events" class="community-events" aria-hidden="false">
                            <div class="activity-block">
                                <p>
                                    <span id="community-events-location-message" aria-hidden="false">Assistez au prochain événement près de chez vous.</span>

                                    <button class="button-link community-events-toggle-location" aria-expanded="false" aria-hidden="false">
                                        <span class="dashicons dashicons-location" aria-hidden="true"></span>
                                        <span class="community-events-location-edit">Sélectionner un emplacement</span>
                                    </button>
                                </p>

                                <form class="community-events-form" aria-hidden="true" action="http://intersect-test.test/wp-admin/admin-ajax.php" method="post">
                                    <label for="community-events-location">
                                        Ville&nbsp;: </label>
                                    <input id="community-events-location" class="regular-text" type="text" name="community-events-location" placeholder="Paris" spellcheck="false" data-ms-editor="true">

                                    <input type="submit" name="community-events-submit" id="community-events-submit" class="button" value="Envoyer">
                                    <button class="community-events-cancel button-link" type="button" aria-expanded="false">
                                        Annuler </button>

                                    <span class="spinner"></span>
                                </form>
                            </div>

                            <ul class="community-events-results activity-block last" aria-hidden="false">

                                <li class="event event-meetup wp-clearfix">
                                    <div class="event-info">
                                        <div class="dashicons event-icon" aria-hidden="true"></div>
                                        <div class="event-info-inner">
                                            <a class="event-title" href="https://www.meetup.com/wordpress-ile-de-france/events/293190455">Atelier FSE 1 : Créer un thème WordPress basé sur des blocs avec theme.json</a>
                                            <span class="event-city">Paris, France</span>
                                        </div>
                                    </div>

                                    <div class="event-date-time">
                                        <span class="event-date">vendredi 26 Mai 2023</span>

                                        <span class="event-time">
                                            18h00 GMT+2
                                        </span>

                                    </div>
                                </li>

                                <li class="event event-wordcamp wp-clearfix">
                                    <div class="event-info">
                                        <div class="dashicons event-icon" aria-hidden="true"></div>
                                        <div class="event-info-inner">
                                            <a class="event-title" href="https://netherlands.wordcamp.org/2023/">WordCamp Netherlands</a>
                                            <span class="event-city">Arnhem, The Netherlands</span>
                                        </div>
                                    </div>

                                    <div class="event-date-time">
                                        <span class="event-date">septembre 7–8, 2023</span>

                                    </div>
                                </li>



                                <li class="event-none">
                                    Vous voulez plus d’évènements&nbsp;? <a href="https://make.wordpress.org/community/organize-event-landing-page/">Aidez à organiser le prochain</a>&nbsp;! </li>


                            </ul>
                        </div>


                        <div class="wordpress-news hide-if-no-js">
                            <div class="rss-widget">
                                <ul>
                                    <li><a class="rsswidget" href="https://fr.wordpress.org/2023/03/30/wordpress-6-2-dolphy/">WordPress 6.2 «&nbsp;Dolphy&nbsp;»</a></li>
                                    <li><a class="rsswidget" href="https://fr.wordpress.org/2023/03/10/guide-des-changements-techniques-de-wordpress-6-2/">Guide des changements techniques de WordPress&nbsp;6.2</a></li>
                                </ul>
                            </div>
                            <div class="rss-widget">
                                <ul>
                                    <li><a class="rsswidget" href="https://wpmarmite.com/double-authentification-wordpress/?utm_source=rss&amp;utm_medium=rss&amp;%23038;utm_campaign=double-authentification-wordpress">Comment activer la double authentification sur votre site WordPress ?</a></li>
                                    <li><a class="rsswidget" href="https://beapi.fr/blog/optimiser-la-conception-wordpress-avec-johannes/">Optimiser la conception WordPress avec Johannes</a></li>
                                    <li><a class="rsswidget" href="https://api.follow.it/track-rss-story-click/v3/8GP0TN3yObgizrhginHnwm7fhEn5oRuR">Bulk Post Status Update</a></li>
                                </ul>
                            </div>
                        </div>

                        <p class="community-events-footer">
                            <a href="https://make.wordpress.org/community/meetups-landing-page" target="_blank">Meetups <span class="screen-reader-text">(ouvre un nouvel onglet)</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>
                            |

                            <a href="https://central.wordcamp.org/schedule/" target="_blank">WordCamps <span class="screen-reader-text">(ouvre un nouvel onglet)</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>
                            |

                            <a href="https://fr.wordpress.org/news/" target="_blank">Actualités <span class="screen-reader-text">(ouvre un nouvel onglet)</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>