<?php
/**
 * Main Entry Point - Prison Management System
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once dirname(__DIR__) . '/src/includes/init.php';

$router = new Router();

/* ===================================================
   PUBLIC ROUTES
=================================================== */
$router->get('home', 'views/components/landing.php');
$router->get('aboutus', 'views/components/aboutus.php');


/* ===================================================
   AUTH ROUTES
=================================================== */
$router->get('signin-admin', 'views/auth/signin-admin.php');
$router->get('signin-jailor', 'views/auth/signin-jailor.php');
$router->get('signin-officer', 'views/auth/signin-officer.php');
$router->get('signin-prisoner', 'views/auth/signin-prisoner.php');
$router->get('signin-lawyer', 'views/auth/signin-lawyer.php');

$router->post('unified-login', 'includes/auth/unified_login.inc.php');
$router->get('logout', 'includes/auth/logout.inc.php');


/* ===================================================
   ADMIN ROUTES
=================================================== */
$router->get('admin', 'controllers/admin/admin.php')->auth('admin');

$router->get('stats', 'controllers/admin/stats.php')->auth('admin');
$router->get('stats_api', 'controllers/admin/stats_api.php')->auth('admin');

$router->get('visitor_pass', 'controllers/admin/visitor_pass.php')->auth('admin');
$router->get('approve-visit', 'controllers/admin/approve_visit.php')->auth('admin');
$router->get('delete_visit', 'controllers/admin/delete_visit.php')->auth('admin');

$router->get('visitor-add', 'controllers/visitor/visitor_add.php')->auth('admin');
$router->post('visitor-add', 'controllers/visitor/visitor_add.php')->auth('admin');

$router->get('add_officer', 'controllers/admin/add_officer.php')->auth('admin');
$router->post('add_officer', 'controllers/admin/add_officer.php')->auth('admin');

$router->get('view_officers', 'controllers/admin/view_officers.php')->auth('admin');

$router->get('generate_menu', 'controllers/admin/generate_menu.php')->auth('admin');
$router->get('lunch', 'controllers/admin/lunch.php')->auth('admin');
$router->get('ai_lunch', 'controllers/admin/ai_lunch.php')->auth('admin');
$router->get('approve_food', 'controllers/admin/approve_food.php')->auth('admin');
$router->get('approved-lunch', 'controllers/admin/approved_lunch.php')->auth('admin');
$router->get('lawyer-visit-approval', 'controllers/admin/lawyer_visit_approval.php')->auth('admin');

$router->get('analytics', 'controllers/admin/analytics.php')->auth('admin');
$router->get(
    'approve-visitor',
    'controllers/visitor/approve_visitor.php'
)->auth('admin');

$router->get(
    'delete-visitor',
    'controllers/visitor/delete_visitor.php'
)->auth('admin');
$router->get(
    'admin-delete-lawyer-visit',
    'controllers/admin/admin_delete_lawyer_visit.php'
)->auth('admin');

$router->get('lawyer-map', 'controllers/admin/lawyer_map.php')->auth('admin');
$router->post('lawyer-map', 'controllers/admin/lawyer_map.php')->auth('admin');
$router->get(
    'delete-lawyer-map',
    'controllers/admin/delete_lawyer_map.php'
)->auth('admin');

$router->get('lawyer-visit-approval', 'controllers/admin/lawyer_visit_approval.php')->auth('admin');
$router->get('approve-lawyer-visit', 'controllers/admin/approve_lawyer_visit.php')->auth('admin');
$router->post('admin-reject-lawyer-visit', 'controllers/admin/admin_reject_lawyer_visit.php')->auth('admin');



/* ===================================================
   OFFICER ROUTES
=================================================== */
$router->get('officer-dashboard', 'controllers/officer/officer-dashboard.php')->auth('officer');
$router->get('officer-view', 'controllers/officer/officer_view.php')->auth('officer');

$router->get('crime', 'controllers/officer/crime.php')->auth('officer');
$router->post('crime-post', 'controllers/officer/crime_post.php')->auth('officer');
$router->get('crime-view', 'controllers/officer/crime_view.php')->auth('officer');
$router->post('crime-view', 'controllers/officer/crime_view.php')->auth('officer');
$router->get('ipc-view', 'controllers/officer/ipc_view.php')->auth('officer');
$router->get('ipc-update', 'controllers/officer/ipc_update.php')->auth('officer');
$router->post('ipc-update', 'controllers/officer/ipc_update.php')->auth('officer');

$router->get('ipc-delete', 'controllers/officer/ipc_delete.php')->auth('officer');
$router->post('ipc-delete', 'controllers/officer/ipc_delete.php')->auth('officer');
$router->get('officer-approve-visitor','controllers/officer/officer_approve_visitor.php')->auth('officer');
$router->get('officer-visitor-visits','controllers/officer/officer_visitor_visits.php')->auth('officer');

$router->get(
    'officer-approve-lawyer-visit',
    'controllers/officer/approve_visit.php'
)->auth('officer');
$router->get(
    'prisoner-dateout',
    'controllers/prisoner/prisoner_dateout.php'
)->auth('officer');

$router->post(
    'prisoner-dateout',
    'controllers/prisoner/prisoner_dateout.php'
)->auth('officer');
$router->get('ipc-view', 'controllers/officer/ipc_view.php')->auth('officer');
$router->get('ipc-update', 'controllers/officer/ipc_update.php')->auth('officer');

$router->post('prisoner-delete', 'controllers/prisoner/prisoner_delete.php')->auth('officer');

$router->get('officer-lawyer-visits', 'controllers/officer/officer_lawyer_visits.php')->auth('officer');
$router->get('officer-approve-lawyer-visit', 'controllers/officer/approve_visit.php')->auth('officer');
$router->post('officer-reject-lawyer-visit', 'controllers/officer/officer_reject_lawyer_visit.php')->auth('officer');


/* ===================================================
   PRISONER ROUTES
=================================================== */

$router->get('prisoner-dashboard',
    'controllers/prisoner/prisoner_dashboard.php')
    ->auth('prisoner');

/* Main pages (single loader) */
$router->get('prisoner-profile',
    'controllers/prisoner/prisoner_main.php')
    ->auth('prisoner');

$router->get('prisoner-sentence',
    'controllers/prisoner/prisoner_main.php')
    ->auth('prisoner');

$router->get('prisoner-section',
    'controllers/prisoner/prisoner_main.php')
    ->auth('prisoner');

$router->get('prisoner-visits',
    'controllers/prisoner/prisoner_main.php')
    ->auth('prisoner');

$router->get('prisoner-crime',
    'controllers/prisoner/prisoner_main.php')
    ->auth('prisoner');

$router->get('prisoner-medical',
    'controllers/prisoner/prisoner_main.php')
    ->auth('prisoner');


/* =======================
   AJAX ROUTES
======================= */

$router->get('ajax-profile',
    'views/prisoner/ajax-profile.php')
    ->auth('prisoner');

$router->get('ajax-sentence',
    'views/prisoner/ajax-sentence.php')
    ->auth('prisoner');

$router->get('ajax-section',
    'views/prisoner/ajax-section.php')
    ->auth('prisoner');

$router->get('ajax-visit',
    'views/prisoner/ajax-visit.php')
    ->auth('prisoner');

$router->get('ajax-crime',
    'views/prisoner/ajax-crime.php')
    ->auth('prisoner');

$router->get('ajax-medical',
    'views/prisoner/ajax-medical.php')
    ->auth('prisoner');

$router->get('prisoner-entertainment',
    'controllers/prisoner/prisoner_entertainment.php')
    ->auth('prisoner');

/* ===================================================
   LAWYER ROUTES
=================================================== */
$router->get('lawyer-dashboard', 'controllers/lawyer/lawyer_dashboard.php')->auth('lawyer');
$router->get('lawyer-prisoners', 'controllers/lawyer/lawyer_prisoners.php')->auth('lawyer');

$router->get('lawyer-visit', 'controllers/lawyer/lawyer_visit.php')->auth('lawyer');
$router->post('lawyer-visit', 'controllers/lawyer/lawyer_visit.php')->auth('lawyer');

$router->post('lawyer-notes', 'controllers/lawyer/lawyer_notes.php')->auth('lawyer');
$router->get('lawyer-notes', 'controllers/lawyer/lawyer_notes.php')->auth('lawyer');

$router->post('cancel-lawyer-visit', 'controllers/lawyer/cancel_lawyer_visit.php')->auth('lawyer');
$router->get('my-visits', 'controllers/lawyer/my_visits.php')->auth('lawyer');


/* ===================================================
   VISITOR ROUTES
=================================================== */
$router->get('visitors', 'controllers/visitor/visitors.php')->auth('admin');
$router->get('visitor-view', 'controllers/visitor/visitor_view.php')->auth('admin');
$router->post('visitor-post', 'controllers/visitor/visitor_post.php')->auth('admin');


/* ===================================================
   DISPATCH ROUTER
=================================================== */
$router->dispatch();