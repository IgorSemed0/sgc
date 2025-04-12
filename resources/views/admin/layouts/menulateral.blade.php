<style>
    .custom-scroll::-webkit-scrollbar {
        width: 2px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background-color: #0066ff;
        border-radius: 4px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background-color: #00c8ff;
    }

    /* Styles from HEAD - Kept */
    .sidebar-heading {
        padding: 10px 15px;
        font-size: 0.9em;
        font-weight: bold;
        color: #cccccc; /* Lighter color for headings */
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 15px;
    }
    .sidebar-heading:first-child {
        margin-top: 0;
    }
     .sidebar ul li a {
        padding: 8px 15px; /* Slightly reduced padding */
        font-size: 0.95em; /* Slightly smaller font */
    }
    .sidebar ul i.fas {
        width: 20px; /* Ensure icons align */
        text-align: center;
        margin-right: 8px;
    }
</style>

<aside class="sidebar custom-scroll" style="overflow-y: scroll;">
    <h2 class="hm">SGC</h2>
    <nav>
        <ul class="list-unstyled">
            <li>
                <a href="#" class="link1">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>


                <div class="sidebar-heading">Recepção</div>
                <li> {{-- Link to Receptionist's specific interface --}}
                    <a href"#" class="link2">
                        <i class="fas fa-concierge-bell"></i> Atendimento Recepção
                    </a>
                </li>
        </ul>
    </nav>
</aside>
