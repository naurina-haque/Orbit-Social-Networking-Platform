<aside class="hp-sidebar">
                <div class="hp-card hp-stat-card" style="margin-bottom:16px;">
                    <div>
                        <div class="hp-stat-num">{{ $friendsCount }}</div>
                        <div class="hp-stat-label">Friends</div>
                    </div>
                    <div>
                        <div class="hp-stat-num">{{ $postsCount }}</div>
                        <div class="hp-stat-label">Posts</div>
                    </div>
                </div>

                <div class="hp-right-title">Friend Requests</div>
                <div class="hp-card" style="padding:6px;margin-bottom:16px;" id="friend-requests-box">
                    @forelse ($pendingRequests as $request)
                        <div class="hp-req-item" id="request-{{ $request->id }}">
                            <a href="{{ route('profile.show', $request->sender->id) }}" style="text-decoration:none;">
                                <span class="hp-avatar-ring xs"><img src="{{ $request->sender->profile_photo ? asset('storage/' . $request->sender->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                            </a>
                            <div class="hp-info">
                                <div class="hp-name">{{ $request->sender->name }}</div>
                                <div class="hp-sub">Wants to be friends</div>
                            </div>
                            <div class="hp-req-actions">
                                <button
                                    type="button"
                                    class="hp-req-btn hp-accept accept-req-btn"
                                    data-request-id="{{ $request->id }}"
                                    data-accept-url="{{ route('friend-request.accept', $request->id) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                </button>
                                <button
                                    type="button"
                                    class="hp-req-btn hp-decline decline-req-btn"
                                    data-request-id="{{ $request->id }}"
                                    data-decline-url="{{ route('friend-request.decline', $request->id) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-width="3"><path d="M6 6l12 12M18 6L6 18"/></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="padding:14px; text-align:center; color:#64748B; font-size:13px;">No pending requests</div>
                    @endforelse
                </div>

                <div class="hp-right-title">People you may know</div>
                <div class="hp-card" style="padding:6px;">
                    @forelse ($suggestedUsers as $user)
                        <div class="hp-suggest" id="suggest-{{ $user->id }}">
                            <a href="{{ route('profile.show', $user->id) }}" style="text-decoration:none; display:flex; align-items:center; gap:10px; flex:1; min-width:0;">
                                <span class="hp-avatar-ring xs"><img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                                <div class="hp-info">
                                    <div class="hp-name">{{ $user->name }}</div>
                                    <div class="hp-sub">Orbit user</div>
                                </div>
                            </a>
                             <button
                                 type="button"
                                 class="hp-add-friend-btn add-friend-btn"
                                 data-user-id="{{ $user->id }}"
                                 data-send-url="{{ route('friend-request.send', $user->id) }}"
                             >
                                 Add Friend
                             </button>
                        </div>
                    @empty
                        <div style="padding:14px; text-align:center; color:#64748B; font-size:13px;">No suggestions right now</div>
                    @endforelse
                </div>
            </aside>
