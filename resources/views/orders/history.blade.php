@extends('layouts.front')

@section('content')
<style>
    /* 1. Background Layering */
    .history-page {
        padding-top: 180px;
        padding-bottom: 120px;
        background-color: #f9f9f9; /* Off-white agar kartu putih terlihat pop-out */
        min-height: 100vh;
        font-family: 'Jost', sans-serif;
    }

    /* 2. Container Luxury */
    .content-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* 3. Typography & Titles */
    .page-header {
        margin-bottom: 60px;
        border-left: 1px solid #000;
        padding-left: 30px;
    }

    .main-title {
        font-size: 2.8rem;
        font-weight: 200;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: #111;
        line-height: 1;
    }

    /* 4. Luxury Row Cards (Bukan Tabel Biasa) */
    .order-list-header {
        display: grid;
        grid-template-columns: 1.5fr 2fr 2fr 1.5fr 1fr;
        padding: 0 30px 15px 30px;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #999;
    }

    .order-row-card {
        display: grid;
        grid-template-columns: 1.5fr 2fr 2fr 1.5fr 1fr;
        align-items: center;
        background: #ffffff;
        margin-bottom: 12px;
        padding: 30px;
        border: 1px solid #eee;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .order-row-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.04);
        border-color: #000;
    }

    /* 5. Enhanced Luxury Badges */
    .badge-status {
        font-size: 8px;
        letter-spacing: 0.15em;
        padding: 6px 14px;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 0px; /* Sharp edge */
        display: inline-block;
        text-align: center;
        min-width: 100px;
    }

    .status-pending { background-color: #111; color: #fff; } /* Hitam untuk kesan eksklusif */
    .status-completed { background-color: #f4f4f4; color: #6b7e6b; border: 1px solid #e2e8e2; }
    .status-cancelled { background-color: #fff; color: #a37e7e; border: 1px solid #e8dede; }

    /* 6. Action Elements */
    .price-text {
        font-size: 15px;
        font-weight: 500;
        color: #111;
        letter-spacing: 0.05em;
    }

    .btn-detail {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #111;
        text-decoration: none;
        position: relative;
        padding-bottom: 4px;
    }

    .btn-detail::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 1px;
        bottom: 0;
        left: 0;
        background-color: #000;
        transform: scaleX(0.3);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .btn-detail:hover::after {
        transform: scaleX(1);
    }

    .back-nav {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.3em;
        color: #999;
        margin-bottom: 15px;
        display: block;
    }
</style>

<div class="history-page">
    <div class="content-container">
        
        <header class="page-header">
            <a href="{{ url('/') }}" class="back-nav">← Back to Scents</a>
            <h1 class="main-title">Order<br>History</h1>
            <p class="mt-4 text-[10px] uppercase tracking-widest text-gray-400">
                Viewing orders for: <span class="text-black font-semibold">{{ Auth::user()->name }}</span>
            </p>
        </header>

        @if($orders->isEmpty())
            <div class="py-20 text-center border border-dashed border-gray-200">
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400">Your collection is empty</p>
                <a href="{{ url('/') }}" class="mt-8 inline-block bg-black text-white px-12 py-4 text-[10px] uppercase tracking-[0.2em]">Explore Catalog</a>
            </div>
        @else
            <div class="order-list-header hidden md:grid">
                <div>ID</div>
                <div>Purchased On</div>
                <div class="text-center">Total Amount</div>
                <div class="text-center">Status</div>
                <div class="text-right">Manage</div>
            </div>

            @foreach($orders as $order)
                <div class="order-row-card">
                    <div class="text-sm font-bold tracking-tighter">#{{ $order->id }}</div>
                    
                    <div class="text-[11px] text-gray-500 uppercase tracking-widest">
                        {{ $order->created_at->format('M d, Y') }}
                    </div>
                    
                    <div class="text-center price-text">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                    
                    <div class="text-center">
                        <span class="badge-status status-{{ strtolower($order->status) }}">
                            {{ $order->status }}
                        </span>
                    </div>
                    
                    <div class="text-right">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn-detail">View</a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
@endsection