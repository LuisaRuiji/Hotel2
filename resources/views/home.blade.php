@extends('layouts.app')

@section('content')

    <section class="hero-section position-relative vh-75">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner vh-75">
                <div class="carousel-item active" style="background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.4);"></div>
                    <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                        <div>
                            <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Your Sanctuary of Serenity</h1>
                            <p class="lead mb-5 animate__animated animate__fadeInUp animate__delay-1s">Discover unparalleled comfort and impeccable service in the heart of the city.</p>
                            <a href="#booking-bar" class="btn btn-lg px-5 py-3 fw-semibold animate__animated animate__fadeInUp animate__delay-2s" style="background-color: #A7C5BD; color: #2E3B4E; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;">
                                Book Your Stay
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="background: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.4);"></div>
                    <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                        <div>
                            <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Luxurious Comfort</h1>
                            <p class="lead mb-5 animate__animated animate__fadeInUp animate__delay-1s">Experience world-class Services and exceptional hospitality.</p>
                            <a href="#rooms" class="btn btn-lg px-5 py-3 fw-semibold animate__animated animate__fadeInUp animate__delay-2s" style="background-color: #A7C5BD; color: #2E3B4E; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;">
                                View Our Rooms
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="background: url('https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.4);"></div>
                    <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                        <div>
                            <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Unforgettable Experiences</h1>
                            <p class="lead mb-5 animate__animated animate__fadeInUp animate__delay-1s">Create lasting memories in our pristine surroundings.</p>
                            <a href="#amenities" class="btn btn-lg px-5 py-3 fw-semibold animate__animated animate__fadeInUp animate__delay-2s" style="background-color: #A7C5BD; color: #2E3B4E; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;">
                                Explore Amenities
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section id="booking-bar" class="py-4" style="background-color: #F5F7F6;">
        <div class="container">
            <form class="row g-3 align-items-center justify-content-center">
                <div class="col-md-3">
                    <label for="checkin" class="form-label visually-hidden">Check-in Date</label>
                    <input type="date" class="form-control form-control-lg" id="checkin" placeholder="Check-in">
                </div>
                <div class="col-md-3">
                    <label for="checkout" class="form-label visually-hidden">Check-out Date</label>
                    <input type="date" class="form-control form-control-lg" id="checkout" placeholder="Check-out">
                </div>
                <div class="col-md-2">
                    <label for="guests" class="form-label visually-hidden">Guests</label>
                    <select class="form-select form-select-lg" id="guests">
                        <option selected>Guests</option>
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4+ Guests</option>
                    </select>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-lg w-100 px-4" style="background-color: #2E3B4E; color: #FFFFFF;">Check Availability</button>
                </div>
            </form>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-5 mb-4" style="color: #2E3B4E;">Discover The Modern Hotel</h2>
                    <p class="lead mb-4" style="color: #5a687c;">
                        Nestled in a prime location, The Modern Hotel offers a unique blend of contemporary design and warm hospitality. We are dedicated to providing an exceptional experience, ensuring every stay is comfortable, memorable, and tailored to your needs.
                    </p>
                    <a href="/about-us" class="btn btn-outline-dark py-2 px-4" style="border-color: #A7C5BD; color: #2E3B4E;">Learn More About Us</a>
                </div>
            </div>
        </div>
    </section>

    <section id="rooms" class="py-5" style="background-color: #FFFFFF;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold" style="color: #2E3B4E;">Our Accommodations</h2>
                <p class="lead" style="color: #5a687c;">Elegantly designed rooms and suites for your ultimate comfort.</p>
            </div>
            
            @if(isset($rooms) && count($rooms) > 0)
                @foreach($rooms as $type => $typeRooms)
                    <div class="mb-5 room-section" style="background: linear-gradient(90deg, #F8FAFC 80%, #E0E7EF 100%); border-radius: 18px; padding: 2.5rem 1.5rem 2rem 1.5rem; margin-bottom: 3rem;">
                        <div class="d-flex align-items-center mb-2" style="gap: 0.75rem;">
                            <i class="fas fa-bed" style="color: #D946EF; font-size: 2rem;"></i>
                            <h2 class="h1 mb-0 fw-bold room-section-title" style="color: #1E3A5F; font-size: 2.2rem; letter-spacing: 0.5px;">{{ $type }}</h2>
                        </div>
                        <div style="height: 4px; width: 80px; background: linear-gradient(90deg, #D946EF 0%, #5EEAD4 100%); border-radius: 2px; margin-bottom: 2.2rem;"></div>
                        <div class="row g-4 g-lg-5">
                            @foreach($typeRooms as $room)
                                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                                    {{-- Assuming x-room-card has a modern, minimalist design --}}
                                    {{-- Example of how you might want your room card to look minimal:
                                        <div class="card h-100 border-0 shadow-sm room-card">
                                            <img src="{{ $room->imageUrl ?? 'https://picsum.photos/seed/'.$room->id.'/400/250' }}" class="card-img-top" alt="{{ $room->name }}">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title" style="color: #2E3B4E;">{{ $room->name }}</h5>
                                                <p class="card-text small flex-grow-1" style="color: #5a687c;">{{ Str::limit($room->description, 80) }}</p>
                                                <div class="mt-auto">
                                                    <span class="fw-bold fs-5 me-2" style="color: #A7C5BD;">${{ $room->price }}/night</span>
                                                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm" style="background-color: #2E3B4E; color: white;">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    --}}
                                    <x-room-card :room="$room" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    <p class="lead">No rooms currently available. Please check back later.</p>
                </div>
            @endif
        </div>
    </section>

    <section id="amenities" class="py-5" style="background-color: #1E3A5F;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold" style="color: #5EEAD4;">Hotel Amenities</h2>
                <p class="lead" style="color: #fff;">Everything you need for a perfect stay.</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-wifi fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">Free High-Speed WiFi</h4>
                        <p class="small" style="color: #fff;">Stay connected throughout the hotel.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-concierge-bell fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">24/7 Front Desk</h4>
                        <p class="small" style="color: #fff;">Always here to assist you.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-parking fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">Secure Parking</h4>
                        <p class="small" style="color: #fff;">Hassle-free parking on-site.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-utensils fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">On-site Restaurant</h4>
                        <p class="small" style="color: #fff;">Delicious dining options available.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-swimmer fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">Swimming Pool</h4>
                        <p class="small" style="color: #fff;">Relax and unwind by the pool.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-dumbbell fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">Fitness Center</h4>
                        <p class="small" style="color: #fff;">Stay active during your stay.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-coffee fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">Daily Housekeeping</h4>
                        <p class="small" style="color: #fff;">Clean and fresh rooms daily.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 amenity-card" style="background: rgba(255,255,255,0.07); border-radius: 14px; border-bottom: 3px solid #D946EF; transition: box-shadow 0.3s;">
                        <i class="fas fa-shield-alt fa-3x mb-3" style="color: #5EEAD4; text-shadow: 0 2px 8px #D946EF44;"></i>
                        <h4 class="h5 mb-2" style="color: #fff;">Enhanced Safety</h4>
                        <p class="small" style="color: #fff;">Your safety is our priority.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5" style="background-color: #FFFFFF;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold" style="color: #2E3B4E;">Premium Services</h2>
                <div class="section-header-accent"></div>
                <p class="lead" style="color: #5a687c;">Enhance your stay with our exclusive services.</p>
            </div>

            <div class="row g-4">
                <!-- Spa & Wellness -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm service-card" style="background: #fff; border-radius: 18px; border-top: 4px solid #D946EF; box-shadow: 0 2px 12px rgba(30,58,95,0.07); transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Spa & Wellness" style="border-top-left-radius: 18px; border-top-right-radius: 18px; height: 260px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="padding: 2rem 1.5rem 1.5rem 1.5rem;">
                            <h5 class="card-title"><i class="fas fa-spa" style="color: #D946EF;"></i> Spa & Wellness</h5>
                            <p class="card-text">Indulge in relaxing massages, facials, and body treatments at our luxury spa.</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="h4 mb-0" style="color: #D946EF; font-weight: 800; font-size: 2rem;">₱1,500.00</span>
                                        <span class="small text-muted" style="font-size: 1.1rem;">/service</span>
                                    </div>
                                </div>
                                <button class="btn btn-book-service w-100 py-3" onclick="alert('Please login to book services.')">
                                    BOOK SERVICE <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dining & Restaurant -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm service-card" style="background: #fff; border-radius: 18px; border-top: 4px solid #D946EF; box-shadow: 0 2px 12px rgba(30,58,95,0.07); transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Dining" style="border-top-left-radius: 18px; border-top-right-radius: 18px; height: 260px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="padding: 2rem 1.5rem 1.5rem 1.5rem;">
                            <h5 class="card-title"><i class="fas fa-utensils" style="color: #3B82F6;"></i> Fine Dining</h5>
                            <p class="card-text">Experience exquisite cuisine prepared by world-class chefs in our restaurant.</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="h4 mb-0" style="color: #D946EF; font-weight: 800; font-size: 2rem;">₱800.00</span>
                                        <span class="small text-muted" style="font-size: 1.1rem;">/service</span>
                                    </div>
                                </div>
                                <button class="btn btn-book-service w-100 py-3" onclick="alert('Please login to book services.')">
                                    RESERVE TABLE <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transportation -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm service-card" style="background: #fff; border-radius: 18px; border-top: 4px solid #D946EF; box-shadow: 0 2px 12px rgba(30,58,95,0.07); transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;">
                        <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Transportation" style="border-top-left-radius: 18px; border-top-right-radius: 18px; height: 260px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="padding: 2rem 1.5rem 1.5rem 1.5rem;">
                            <h5 class="card-title"><i class="fas fa-car" style="color: #5EEAD4;"></i> Luxury Transportation</h5>
                            <p class="card-text">Airport transfers and city tours in our fleet of premium vehicles.</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="h4 mb-0" style="color: #D946EF; font-weight: 800; font-size: 2rem;">₱1,200.00</span>
                                        <span class="small text-muted" style="font-size: 1.1rem;">/service</span>
                                    </div>
                                </div>
                                <button class="btn btn-book-service w-100 py-3" onclick="alert('Please login to book services.')">
                                    BOOK TRANSFER <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Services -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm service-card" style="background: #fff; border-radius: 18px; border-top: 4px solid #D946EF; box-shadow: 0 2px 12px rgba(30,58,95,0.07); transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;">
                        <img src="https://images.unsplash.com/photo-1497215842964-222b430dc094?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Business Services" style="border-top-left-radius: 18px; border-top-right-radius: 18px; height: 260px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="padding: 2rem 1.5rem 1.5rem 1.5rem;">
                            <h5 class="card-title"><i class="fas fa-briefcase" style="color: #1E3A5F;"></i> Business Center</h5>
                            <p class="card-text">Meeting rooms, conference facilities, and business support services.</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="h4 mb-0" style="color: #D946EF; font-weight: 800; font-size: 2rem;">₱2,000.00</span>
                                        <span class="small text-muted" style="font-size: 1.1rem;">/service</span>
                                    </div>
                                </div>
                                <button class="btn btn-book-service w-100 py-3" onclick="alert('Please login to book services.')">
                                    RESERVE SPACE <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activities & Recreation -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm service-card" style="background: #fff; border-radius: 18px; border-top: 4px solid #D946EF; box-shadow: 0 2px 12px rgba(30,58,95,0.07); transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;">
                        <img src="https://images.unsplash.com/photo-1526485856375-9110812fbf35?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Activities" style="border-top-left-radius: 18px; border-top-right-radius: 18px; height: 260px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="padding: 2rem 1.5rem 1.5rem 1.5rem;">
                            <h5 class="card-title"><i class="fas fa-hiking" style="color: #3B82F6;"></i> Recreation Activities</h5>
                            <p class="card-text">Guided tours, cooking classes, and local cultural experiences.</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="h4 mb-0" style="color: #D946EF; font-weight: 800; font-size: 2rem;">₱1,000.00</span>
                                        <span class="small text-muted" style="font-size: 1.1rem;">/service</span>
                                    </div>
                                </div>
                                <button class="btn btn-book-service w-100 py-3" onclick="alert('Please login to book services.')">
                                    BOOK ACTIVITY <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laundry -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm service-card" style="background: #fff; border-radius: 18px; border-top: 4px solid #D946EF; box-shadow: 0 2px 12px rgba(30,58,95,0.07); transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;">
                        <img src="https://images.unsplash.com/photo-1582735689369-4fe89db7114c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Laundry" style="border-top-left-radius: 18px; border-top-right-radius: 18px; height: 260px; object-fit: cover;">
                        <div class="card-body d-flex flex-column" style="padding: 2rem 1.5rem 1.5rem 1.5rem;">
                            <h5 class="card-title"><i class="fas fa-soap" style="color: #D946EF;"></i> Laundry & Dry Cleaning</h5>
                            <p class="card-text">Premium laundry services with express delivery options.</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="h4 mb-0" style="color: #D946EF; font-weight: 800; font-size: 2rem;">₱500.00</span>
                                        <span class="small text-muted" style="font-size: 1.1rem;">/service</span>
                                    </div>
                                </div>
                                <button class="btn btn-book-service w-100 py-3" onclick="alert('Please login to book services.')">
                                    ORDER SERVICE <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="background-color: #F5F7F6;">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="display-5 fw-bold mb-3" style="color: #2E3B4E;">Explore Our Surroundings</h2>
                    <p class="lead mb-4" style="color: #5a687c;">
                        Our hotel is perfectly situated to explore local attractions, vibrant markets, and scenic parks. Experience the best of the city right at your doorstep.
                    </p>
                    <a href="/location" class="btn py-2 px-4" style="background-color: #A7C5BD; color: #2E3B4E;">Discover Local Attractions</a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-2">
                        <div class="col-6">
                            <img src="https://images.unsplash.com/photo-1549918821-83f97d9c5914?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&h=300" class="img-fluid rounded shadow-sm" alt="Local Attraction 1">
                        </div>
                        <div class="col-6">
                            <img src="https://images.unsplash.com/photo-1505826759037-406b40feb402?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&h=300" class="img-fluid rounded shadow-sm" alt="Local Attraction 2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 text-center text-white" style="background-color: #A7C5BD;">
        <div class="container py-4">
            <h2 class="display-5 fw-bold mb-3" style="color: #2E3B4E;">Ready for an Unforgettable Stay?</h2>
            <p class="lead mb-4" style="color: #FFFFFF;">
                We invite you to experience the comfort, luxury, and exceptional service that await you.
            </p>
            <a href="#rooms" class="btn btn-lg px-5 py-3 fw-semibold" style="background-color: #2E3B4E; color: #FFFFFF; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;">
                Book Your Room Now
            </a>
        </div>
    </section>

@endsection

@push('styles')
{{-- Add Animate.css for hero animations (optional) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .hero-section {
        height: 100vh;
        min-height: 600px;
    }
    
    .carousel-item {
        height: 100vh;
        min-height: 600px;
        background-position: center;
        background-size: cover;
    }

    .carousel-caption {
        bottom: 0;
        top: 0;
        padding: 0;
        text-align: center;
    }

    .carousel-indicators {
        margin-bottom: 3rem;
    }

    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .carousel.slide {
        height: 100%;
    }

    .carousel-inner {
        height: 100%;
    }

    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: transform .3s ease-in-out, box-shadow .3s ease-in-out;
    }

    .form-control-lg, .form-select-lg {
        border-radius: 0.5rem; /* softer edges for form fields */
    }

    .service-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
    }
    
    .btn-book-service {
        transition: all 0.3s ease;
    }
    
    .btn-book-service:hover {
        background-color: #A7C5BD !important;
        color: #2E3B4E !important;
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
    }

    #amenities .amenity-card:hover {
        box-shadow: 0 8px 24px rgba(30,58,95,0.18);
        background: rgba(255,255,255,0.13);
        border-bottom: 3px solid #D946EF;
    }

    .room-section {
        background: linear-gradient(90deg, #F8FAFC 80%, #E0E7EF 100%);
        border-radius: 18px;
        padding: 2.5rem 1.5rem 2rem 1.5rem;
        margin-bottom: 3rem;
    }
    .room-section-title {
        color: #1E3A5F;
        font-size: 2.2rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Simple script to set min date for check-in/check-out
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        var checkinInput = document.getElementById('checkin');
        var checkoutInput = document.getElementById('checkout');

        if(checkinInput) {
            checkinInput.setAttribute('min', today);
            checkinInput.addEventListener('change', function() {
                if (checkoutInput && checkoutInput.value < checkinInput.value) {
                    checkoutInput.value = checkinInput.value;
                }
                if (checkoutInput) {
                    checkoutInput.setAttribute('min', checkinInput.value);
                }
            });
        }
        if(checkoutInput && !checkinInput.value) {
             checkoutInput.setAttribute('min', today);
        }
    });
</script>
@endpush