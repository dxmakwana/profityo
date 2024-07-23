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
             @if(($access['estimates']) || ($access['invoices']) || ($access['payments_setup']) || ($access['recurring_invoices']) || ($access['customer_statements']) || ($access['customers']) || ($access['product_services_sales']))
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Sales & Payments
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            @endif
            <ul class="nav nav-treeview">
              @if(isset($access['estimates']) && $access['estimates'])
              <li class="nav-item">
                <a href="estimates-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Estimates</p>
                </a>
              </li>
              @endif
              @if(isset($access['invoices']) && $access['invoices'])
              <li class="nav-item">
                <a href="invoices-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoices</p>
                </a>
              </li>
              @endif
              @if(isset($access['payments_setup']) && $access['payments_setup'])
              <li class="nav-item">
                <a href="payments-setup.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payments Setup</p>
                </a>
              </li>
              @endif
              @if(isset($access['recurring_invoices']) && $access['recurring_invoices'])
              <li class="nav-item">
                <a href="recurringinvoices-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recurring Invoices</p>
                </a>
              </li>
              @endif
              @if(isset($access['customer_statements']) && $access['customer_statements'])
              <li class="nav-item">
                <a href="customerstatements.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Statements</p>
                </a>
              </li>
              @endif
              @if(isset($access['customers']) && $access['customers'])
              <li class="nav-item">
                <a href="customers-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customers</p>
                </a>
              </li>
              @endif
              @if(isset($access['product_services_sales']) && $access['product_services_sales'])
              <li class="nav-item">
                <a href="products-services-sales-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products & Services</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          
          <li class="nav-item">
            @if(($access['bills']) || ($access['vendors']) || ($access['product_services_purchases']) )
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Purchases
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>
            @endif
            <ul class="nav nav-treeview">
              @if(isset($access['bills']) && $access['bills'])
              <li class="nav-item">
                <a href="bills-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bills</p>
                </a>
              </li>
              @endif
              @if(isset($access['vendors']) && $access['vendors'])
              <li class="nav-item">
                <a href="vendors-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendors</p>
                </a>
              </li>
              @endif
              @if(isset($access['product_services_purchases']) && $access['product_services_purchases'])
              <li class="nav-item">
                <a href="products-services-purchases-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products & Services</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          <li class="nav-item">
            @if(($access['transections']) || ($access['reconciliation']) || ($access['chart_of_accounts']) )
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Accounting
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            @endif
            <ul class="nav nav-treeview">
              @if(isset($access['transections']) && $access['transections'])
              <li class="nav-item">
                <a href="transactions-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transactions</p>
                </a>
              </li>
              @endif
              @if(isset($access['reconciliation']) && $access['reconciliation'])
              <li class="nav-item">
                <a href="reconciliation.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reconciliation</p>
                </a>
              </li>
              @endif
              @if(isset($access['chart_of_accounts']) && $access['chart_of_accounts'])
              <li class="nav-item">
                <a href="chart-of-accounts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chart of Accounts</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          <li class="nav-item">
          @if(($access['connected_accounts']) )
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Banking
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            @endif
            <ul class="nav nav-treeview">
              @if(isset($access['connected_accounts']) && $access['connected_accounts'])
              <li class="nav-item">
                <a href="connected-accounts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Connected Accounts</p>
                </a>
              </li>
              @endif
            </ul>
          </li> 
          <li class="nav-item">
            @if(($access['employees']) || ($access['timesheets']))
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Payroll
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            @endif
            <ul class="nav nav-treeview">
              @if(isset($access['employees']) && $access['employees'])
              <li class="nav-item">
                <a href="employees-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Employees</p>
                </a>
              </li>
              @endif
              @if(isset($access['timesheets']) && $access['timesheets'])
              <li class="nav-item">
                <a href="timeSheets.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TimeSheets</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          <li class="nav-item">
            @if(($access['profit_loss_report']) || ($access['balance_sheet_report']) || ($access['cash_flow_report']) || ($access['sales_tax_report']) || ($access['income_by_customer_report']) || ($access['aged_receivables_report']) || ($access['purchases_by_vendor_report']) || ($access['aged_payables_report']) || ($access['account_balances_report']) || ($access['account_transactions_leader_report']) || ($access['trial_balance_report'])  )
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-chart-bar"></i>
              <p>
                Reports
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            @endif
            <ul class="nav nav-treeview">
              @if(isset($access['profit_loss_report']) && $access['profit_loss_report'])
              <li class="nav-item">
                <a href="profit-loss-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profit & Loss</p>
                </a>
              </li>
              @endif
              @if(isset($access['balance_sheet_report']) && $access['balance_sheet_report'])
              <li class="nav-item">
                <a href="balance-sheet-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Balance Sheet</p>
                </a>
              </li>
              @endif
              @if(isset($access['cash_flow_report']) && $access['cash_flow_report'])
              <li class="nav-item">
                <a href="cash-flow.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cash flow</p>
                </a>
              </li>
              @endif
              @if(isset($access['sales_tax_report']) && $access['sales_tax_report'])
              <li class="nav-item">
                <a href="sales-tax-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Tax Report</p>
                </a>
              </li>
              @endif
              @if(isset($access['income_by_customer_report']) && $access['income_by_customer_report'])
              <li class="nav-item">
                <a href="income-by-customer-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Income by Customer</p>
                </a>
              </li>
              @endif
              @if(isset($access['aged_receivables_report']) && $access['aged_receivables_report'])
              <li class="nav-item">
                <a href="aged-receivables-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aged Receivables</p>
                </a>
              </li>
              @endif
              @if(isset($access['purchases_by_vendor_report']) && $access['purchases_by_vendor_report'])
              <li class="nav-item">
                <a href="purchases-by-vendor-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchases by Vendor</p>
                </a>
              </li>
              @endif
              @if(isset($access['aged_payables_report']) && $access['aged_payables_report'])
              <li class="nav-item">
                <a href="aged-payables-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aged Payables</p>
                </a>
              </li>
              @endif
              @if(isset($access['account_balances_report']) && $access['account_balances_report'])
              <li class="nav-item">
                <a href="account-balances-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Account Balances</p>
                </a>
              </li>
              @endif
              @if(isset($access['account_transactions_leader_report']) && $access['account_transactions_leader_report'])
              <li class="nav-item">
                <a href="account-transactions-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Account Transactions (Leader)</p>
                </a>
              </li>
              @endif
              @if(isset($access['trial_balance_report']) && $access['trial_balance_report'])
              <li class="nav-item">
                <a href="trial-balance-report.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trial Balance</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          <li class="nav-item {{ request()->is($busadminRoutes.'/profile*') ? ' menu-open  side_shape' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon far fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(isset($access['personal_profile']) && $access['personal_profile'])
              <li class="nav-item">
                <a href="{{ route('business.profile.edit') }}" class="nav-link {{ request()->is($busadminRoutes.'/profile*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Personal Profile</p>
                </a>
              </li>
              @endif
              @if(isset($access['business_profile']) && $access['business_profile'])
              <li class="nav-item">
                <a href="business-profile.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Business Profile</p>
                </a>
              </li>
              @endif
              @if(isset($access['users']) && $access['users'])
              <li class="nav-item">
                <a href="user-list.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              @endif
              @if(isset($access['roles']) && $access['roles'])
              <li class="nav-item">
                <a href="user-role.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
              @endif
              @if(isset($access['roles']) && $access['roles'])
              <li class="nav-item">
                <a href="sales-taxes.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Taxes</p>
                </a>
              </li>
              @endif
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
