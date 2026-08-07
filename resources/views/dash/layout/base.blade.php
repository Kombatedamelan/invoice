<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOUNOUO - Facturation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Même police que la page de connexion -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ===== RÉINITIALISATION ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #0a0f24;
            color: #fff;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        /* ===== ANIMATION D'ARRIÈRE-PLAN ===== */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 50%, rgba(0, 114, 255, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 50%, rgba(0, 242, 254, 0.06) 0%, transparent 60%);
            animation: bgPulse 15s ease-in-out infinite alternate;
            z-index: 0;
            pointer-events: none;
        }

        @keyframes bgPulse {
            0% { transform: scale(1) rotate(0deg); }
            100% { transform: scale(1.1) rotate(3deg); }
        }

        /* ===== BARRE SUPÉRIEURE ===== */
        .top-bar {
            width: 100%;
            height: 75px;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand h2 {
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: 2px;
            background: linear-gradient(135deg, #00f2fe, #4facfe, #0072ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-transform: uppercase;
            position: relative;
        }

        .brand h2::after {
            content: '●';
            color: #00f2fe;
            -webkit-text-fill-color: #00f2fe;
            font-size: 0.5rem;
            position: absolute;
            top: -2px;
            right: -18px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.8); }
        }

        .top-menu {
            display: flex;
            gap: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #a0aec0;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.1), rgba(0, 114, 255, 0.05));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .menu-item:hover::before,
        .menu-item.active::before {
            opacity: 1;
        }

        .menu-item:hover, .menu-item.active {
            color: #fff;
            transform: translateY(-1px);
        }

        .menu-item i {
            position: relative;
            z-index: 1;
            font-size: 1.1rem;
        }

        .menu-item span {
            position: relative;
            z-index: 1;
        }

        .menu-item.active {
            color: #00f2fe;
        }

        .menu-item.active i {
            color: #00f2fe;
        }

        .top-profile {
            display: flex;
            align-items: center;
        }

        .logout-btn {
            color: #ff6b6b;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 12px;
            background: rgba(255, 107, 107, 0.08);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .logout-btn:hover::before {
            opacity: 1;
        }

        .logout-btn:hover {
            color: #ff4757;
            transform: translateY(-1px);
        }

        /* ===== CONTENU PRINCIPAL ===== */
        .main-content {
            width: 100%;
            padding: 40px;
            position: relative;
            z-index: 1;
        }

        /* ===== EN-TÊTE ===== */
        .content-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            animation: fadeUp 0.8s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-text h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #fff;
        }

        .welcome-text p {
            color: #a0aec0;
            font-size: 0.95rem;
            font-weight: 300;
        }

        .welcome-text p i {
            color: #00f2fe;
            margin-right: 6px;
        }

        .btn-create-invoice {
            background: linear-gradient(135deg, #0072ff, #00f2fe);
            border: none;
            padding: 14px 28px;
            border-radius: 14px;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 25px rgba(0, 242, 254, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-create-invoice::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .btn-create-invoice:hover::before {
            opacity: 1;
        }

        .btn-create-invoice:hover {
            box-shadow: 0 8px 35px rgba(0, 242, 254, 0.4);
            transform: translateY(-3px) scale(1.02);
        }

        .btn-create-invoice:active {
            transform: translateY(0) scale(0.98);
        }

        /* ===== LISTE DES FACTURES ===== */
        .invoice-list-section {
            width: 100%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            animation: fadeUp 1s ease-out 0.2s both;
            transition: all 0.3s;
        }

        .invoice-list-section:hover {
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e2e8f0;
        }

        .card-header h2 i { 
            color: #00f2fe;
            font-size: 1.3rem;
        }

        .card-header .badge-count {
            background: rgba(0, 242, 254, 0.1);
            color: #00f2fe;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 12px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        .invoice-table th, .invoice-table td {
            padding: 16px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .invoice-table th {
            color: #a0aec0;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .invoice-table tbody tr {
            transition: all 0.3s ease;
        }

        .invoice-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
            transform: scale(1.002);
        }

        .invoice-table td:first-child {
            font-weight: 600;
            color: #00f2fe;
        }

        .btn-action {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: #a0aec0;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action:hover {
            background: rgba(0, 242, 254, 0.12);
            border-color: rgba(0, 242, 254, 0.2);
            color: #00f2fe;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 242, 254, 0.15);
        }

        .btn-action i {
            font-size: 0.9rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 850px) {
            .top-bar { 
                padding: 0 20px; 
                flex-direction: column; 
                height: auto; 
                padding-top: 15px;
                padding-bottom: 15px;
                gap: 12px; 
            }
            .top-menu { 
                gap: 6px; 
                flex-wrap: wrap; 
                justify-content: center; 
            }
            .menu-item {
                padding: 8px 14px;
                font-size: 0.8rem;
            }
            .menu-item span {
                display: none;
            }
            .content-header { 
                flex-direction: column; 
                align-items: flex-start; 
                gap: 20px; 
            }
            .btn-create-invoice { 
                width: 100%; 
                justify-content: center; 
            }
            .main-content {
                padding: 20px;
            }
            .invoice-list-section {
                padding: 20px 15px;
            }
            .invoice-table th, .invoice-table td {
                padding: 12px 10px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .top-bar {
                padding: 10px 15px;
            }
            .brand h2 {
                font-size: 1.3rem;
            }
            .menu-item {
                padding: 6px 10px;
                font-size: 0.7rem;
            }
            .btn-create-invoice {
                padding: 12px 20px;
                font-size: 0.85rem;
            }
            .invoice-table {
                font-size: 0.75rem;
            }
            .invoice-table th, .invoice-table td {
                padding: 10px 8px;
            }
        }
        .logout-btn{
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font: inherit;
        }
        /* ===== BARRE DE DÉFILEMENT PERSONNALISÉE ===== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #0072ff, #00f2fe);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #00f2fe;
        }
    </style>
</head>
<body>

    <!-- ===== BARRE SUPÉRIEURE ===== -->
   <header class="top-bar">
        <div class="brand">
            <h2>MOUNOUO</h2>
        </div>
        <nav class="top-menu">
            <a href="{{ route('factures.index') }}" class="menu-item {{ request()->routeIs('factures.index') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Factures</span>
            </a>
            <a href="{{ route('factures.create') }}" class="menu-item {{ request()->routeIs('factures.create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Nouvelle facture</span>
            </a>
            <!-- <a href="#" class="menu-item">
                <i class="fa-solid fa-gear"></i>
                <span>Paramètres</span>
            </a> -->
        </nav>
        <form action="{{ route('login.logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Déconnexion</span>
            </button>
        </form>
    </header>

    <!-- ===== CONTENU PRINCIPAL ===== -->
    <main class="main-content">
        
        @yield("main")

    </main>

</body>
</html>