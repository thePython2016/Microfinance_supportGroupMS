   <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" >
          <div class="app-brand demo">
            <a href="admin.php" class="app-brand-link">
              <span class="app-brand-logo demo me-1">
                <span style="color: var(--bs-primary)">
                  <!-- <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z"
                      fill="currentColor" />
                    <path
                      opacity="0.077704"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z"
                      fill="black" />
                    <path
                      opacity="0.077704"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z"
                      fill="black" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z"
                      fill="currentColor" />
                    <path
                      opacity="0.077704"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z"
                      fill="black" />
                    <path
                      opacity="0.077704"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z"
                      fill="black" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                      fill="currentColor" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                      fill="white"
                      fill-opacity="0.15" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                      fill="currentColor" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                      fill="white"
                      fill-opacity="0.3" />
                  </svg>
                </span>
              </span>
              <span class="app-brand-text demo menu-text title fw-semibold ms-2 mt-10 mb-10"
              style="font-size:20px !important;font-weight:bold !important">MFSGMS</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="menu-toggle-icon d-xl-block align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow" ></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item">
              <a href="admin.php" class="menu-link dashboard-text">
              <i class="fa-solid fa-gauge-simple fa-icon"></i>
                <div>Dashboard</div>
              </a>
            </li>

            <!-- Layouts -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="fa-solid fa-users fa-icon"></i>
                <div data-i18n="Layouts">Members</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="members.php" class="menu-link">
                    <div data-i18n="Without menu">Add Member</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="members-list.php" class="menu-link">
                    <div data-i18n="Without navbar">Members List</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="members-share.php" class="menu-link">
                    <div data-i18n="Container">Members by Share</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="members-loan.php" class="menu-link">
                    <div data-i18n="Fluid">Members by Loan</div>
                  </a>
                </li>
                <!-- <li class="menu-item">
                  <a href="loan-status.php" class="menu-link">
                    <div data-i18n="Fluid">Loan Status</div>
                  </a>
                </li> -->
               
              </ul>
            </li>

            <!-- Front Pages -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="fa-solid fa-money-bill fa-icon"></i>
                <div data-i18n="Front Pages">Shares</div>
        
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a
                    href="shares.php"
                    class="menu-link"
                    >
                    <div data-i18n="Landing">Add Share</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a
                    href="shares-list.php"
                    class="menu-link"
                    >
                    <div data-i18n="Pricing">Shares List</div>
                  </a>
                </li>
             
               
            
              </ul>
            </li>

            <!-- Apps -->
         
        
        
      
            <!-- Pages -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="fa-solid fa-user-tie fa-icon"></i>
                <div data-i18n="Account Settings">Financial Officers</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="financial-officers.php" class="menu-link">
                    <div data-i18n="Account">Add Financial Officers</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="officers-list.php" class="menu-link">
                    <div data-i18n="Notifications">Financial Officers List</div>
                  </a>
                </li>
               
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="fa-solid fa-money-bill-1-wave fa-icon"></i>
                <div data-i18n="Authentications">Loan</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="loans.php" class="menu-link" >
                    <div data-i18n="Basic">Member's Loan</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="check-loan.php" class="menu-link" >
                    <div data-i18n="Basic">Check Member's Loan</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="loan-payment.php" class="menu-link" >
                    <div data-i18n="Basic">Loan Payment</div>
                  </a>
                </li>
               
                </li>
              </ul>
            </li>
          
        
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="fa-solid fa-envelope fa-icon"></i>
                <div data-i18n="Authentications">Compose e-Message</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="compose-message.php" class="menu-link" >
                    <div data-i18n="Basic">Compose Message</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="check-loan.php" class="menu-link" >
                    <div data-i18n="Basic">Sent Message</div>
                  </a>
                </li>
  </ul>
               
                </li>

           

            <!-- Icons -->
            <li class="menu-item">
              <a href="reports.php" class="menu-link">
              <i class="fa-regular fa-flag fa-icon"></i>
                <div data-i18n="Icons">Reports</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="charts.php" class="menu-link">
              <i class="fa-solid fa-chart-line fa-icon"></i>
                <div data-i18n="Icons">Charts</div>
              </a>
            </li>
            







         

          
          
     
          </ul>
  </li>
        </aside>