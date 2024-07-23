<!-- Main Sidebar Container -->
@php($busadminRoutes = config('global.businessAdminURL'))
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('business.home') }}" class="brand-link">
      <img src="{{url('public/dist/img/logo.png')}}" alt="Profityo Logo" class="brand-image">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{ request()->is($busadminRoutes.'/dashboard*') || request()->is($busadminRoutes.'/profile*') ? 'side_shape' : '' }}">
            <a href="{{ route('business.home') }}" class="nav-link {{ request()->is($busadminRoutes.'/dashboard*') || request()->is($busadminRoutes.'/profile*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Sales & Payments
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="estimates-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Estimates</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="invoices-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoices</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="payments-setup.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payments Setup</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="recurringinvoices-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recurring Invoices</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="customerstatements.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Statements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="customers-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="products-services-sales-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products & Services</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Purchases
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="bills-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bills</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vendors-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendors</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="products-services-purchases-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products & Services</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Accounting
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="transactions-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transactions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="reconciliation.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reconciliation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="chart-of-accounts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chart of Accounts</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Banking
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="connected-accounts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Connected Accounts</p>
                </a>
              </li>
            </ul>
          </li> 
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Payroll
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employees-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Employees</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="timeSheets.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TimeSheets</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-chart-bar"></i>
              <p>
                Reports
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="profit-loss-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profit & Loss</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="balance-sheet-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Balance Sheet</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cash-flow.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cash flow</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sales-tax-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Tax Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="income-by-customer-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Income by Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="aged-receivables-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aged Receivables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="purchases-by-vendor-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchases by Vendor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="aged-payables-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aged Payables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="account-balances-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Account Balances</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="account-transactions-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Account Transactions (Leader)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="trial-balance-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trial Balance</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="profile.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Personal Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="business-profile.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Business Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user-role.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sales-taxes.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Taxes</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <form id="logout-form" method="POST" action="{{ route('business.logout') }}" style="display: none;">
                @csrf
            </form>

            <a href="{{ route('business.logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Log Out</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
