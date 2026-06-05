
const gambar = ["belanja.jpg","minum.jpg","tempat.jpg","ini.jpg"];
let index = 0;
function tampilSlide() {
    document.getElementById("slide").src = gambar[index];
    document.querySelectorAll(".dot").forEach((d,i) => d.classList.toggle("active", i===index));
}
function nextSlide() { index = (index+1) % gambar.length; tampilSlide(); }
function prevSlide() { index = (index-1+gambar.length) % gambar.length; tampilSlide(); }
setInterval(nextSlide, 3000);

function toggleNav() {
    document.getElementById("mainNav").classList.toggle("open");
    document.getElementById("burgerBtn").classList.toggle("open");
}
document.querySelectorAll("nav a").forEach(a => a.addEventListener("click", () => {
    document.getElementById("mainNav").classList.remove("open");
    document.getElementById("burgerBtn").classList.remove("open");
}));
function toggleNav() {
    document.getElementById("mainNav").classList.toggle("open");
    document.getElementById("burgerBtn").classList.toggle("open");
}
document.querySelectorAll("nav a").forEach(a => a.addEventListener("click", () => {
    document.getElementById("mainNav").classList.remove("open");
    document.getElementById("burgerBtn").classList.remove("open");
}));
let lastAdded = null;

function getCart() {
    try { return JSON.parse(localStorage.getItem("pesananCart")) || []; } catch(e) { return []; }
}
function saveCart(cart) { localStorage.setItem("pesananCart", JSON.stringify(cart)); }

function updateBadge() {
    const total = getCart().reduce((s,i) => s+i.qty, 0);
    const badge = document.getElementById("cartBadge");
    badge.textContent = total;
    total > 0 ? badge.classList.add("show") : badge.classList.remove("show");
}

function pesanProduk(nama, harga, img) {
    const cart = getCart();
    const existing = cart.find(i => i.nama === nama);
    if (existing) existing.qty += 1;
    else cart.push({ nama, harga, img, qty: 1 });
    saveCart(cart);
    updateBadge();
    lastAdded = { nama, harga };
    document.getElementById("popup").style.display = "flex";
    document.getElementById("popupText").innerHTML =
        "✅ <b>" + nama + "</b> ditambahkan!<br>Harga: <b>Rp " + harga.toLocaleString('id-ID') + "</b>";
}

function tutupPopup() { document.getElementById("popup").style.display = "none"; lastAdded = null; }
function lihatKeranjang() { document.getElementById("popup").style.display = "none"; window.location.href = "pesan.html"; }
function batalPesanan() {
    if (!lastAdded) { tutupPopup(); return; }
    const cart = getCart();
    const idx = cart.findIndex(i => i.nama === lastAdded.nama);
    if (idx !== -1) {
        cart[idx].qty -= 1;
        if (cart[idx].qty <= 0) cart.splice(idx, 1);
        saveCart(cart); updateBadge();
    }
    tutupPopup();
}

function toggleNav() {
    document.getElementById("mainNav").classList.toggle("open");
    document.getElementById("burgerBtn").classList.toggle("open");
}
document.querySelectorAll("nav a").forEach(a => a.addEventListener("click", () => {
    document.getElementById("mainNav").classList.remove("open");
    document.getElementById("burgerBtn").classList.remove("open");
}));

updateBadge();
let cart = [];

function loadCart() {
    try { cart = JSON.parse(localStorage.getItem("pesananCart")) || []; }
    catch(e) { cart = []; }
}
function saveCart() { localStorage.setItem("pesananCart", JSON.stringify(cart)); }

function renderCart() {
    const container = document.getElementById("cartContainer");
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="cart-empty">
                <span class="big-emoji">🛍️</span>
                Keranjang masih kosong.<br>
                <a href="produk.html" style="color:var(--green);font-weight:800;">👉 Pilih produk dulu yuk!</a>
            </div>`;
        return;
    }
    let total = 0;
    let rows = cart.map((item, i) => {
        const sub = item.harga * item.qty;
        total += sub;
        const imgTag = item.img
            ? `<img src="${item.img}" class="prod-img" alt="${item.nama}">`
            : `<div style="width:62px;height:62px;background:var(--green-pale);border-radius:12px;margin:auto;display:flex;align-items:center;justify-content:center;font-size:28px;">🥛</div>`;
        return `
        <tr id="row-${i}">
            <td>${imgTag}</td>
            <td class="prod-name">${item.nama}</td>
            <td>
                <div class="qty-cell">
                    <button onclick="changeQty(${i},-1)">−</button>
                    <span>${item.qty}</span>
                    <button onclick="changeQty(${i},1)">+</button>
                </div>
            </td>
            <td class="prod-price">Rp ${sub.toLocaleString('id-ID')}</td>
            <td><button class="delete-btn" onclick="removeItem(${i})">🗑️</button></td>
        </tr>`;
    }).join('');

    container.innerHTML = `
        <div class="cart-table-wrap">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Foto</th><th>Produk</th><th>Jumlah</th><th>Subtotal</th><th>Hapus</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        </div>
        <div class="cart-total">
            <span class="label">💰 Total Pesanan</span>
            <span class="amount">Rp ${total.toLocaleString('id-ID')}</span>
        </div>`;
}

function removeItem(i) {
    const row = document.getElementById("row-"+i);
    if (row) row.classList.add("removing");
    setTimeout(() => { cart.splice(i,1); saveCart(); renderCart(); }, 340);
}
function changeQty(i, delta) {
    cart[i].qty = Math.max(1, cart[i].qty + delta);
    saveCart(); renderCart();
}
function clearAll() {
    if (confirm("Hapus semua pesanan?")) { cart = []; saveCart(); renderCart(); }
}

function submitOrder() {
    const nama   = document.getElementById("nama").value.trim();
    const alamat = document.getElementById("alamat").value.trim();
    const hp     = document.getElementById("hp").value.trim();
    const bayar  = document.getElementById("bayar").value;
    if (!nama || !alamat || !hp) { alert("Mohon lengkapi nama, alamat, dan nomor HP dulu ya! 😊"); return; }
    if (cart.length === 0) { alert("Keranjang masih kosong, pilih produk dulu! 🛒"); return; }
    let detail = cart.map(i => `${i.qty}x ${i.nama} = Rp ${(i.harga*i.qty).toLocaleString('id-ID')}`).join('%0A');
    const total = cart.reduce((s,i) => s + i.harga*i.qty, 0);
    detail += `%0A%0A💰 *Total: Rp ${total.toLocaleString('id-ID')}*`;
    const msg =
        "Halo! Saya ingin memesan susu sapi segar 🥛%0A%0A" +
        "📝 *Detail Pesanan:*%0A" + detail + "%0A%0A" +
        "👤 *Nama:* " + encodeURIComponent(nama) + "%0A" +
        "📍 *Alamat:* " + encodeURIComponent(alamat) + "%0A" +
        "📱 *HP:* " + encodeURIComponent(hp) + "%0A" +
        "💳 *Pembayaran:* " + encodeURIComponent(bayar);
    window.open("https://wa.me/6281282481503?text=" + msg, "_blank");
    cart = []; saveCart(); renderCart();
}

function toggleNav() {
    document.getElementById("mainNav").classList.toggle("open");
    document.getElementById("burgerBtn").classList.toggle("open");
}
document.querySelectorAll("nav a").forEach(a => a.addEventListener("click", () => {
    document.getElementById("mainNav").classList.remove("open");
    document.getElementById("burgerBtn").classList.remove("open");
}));

loadCart();
renderCart();
function toggleNav() {
    document.getElementById("mainNav").classList.toggle("open");
    document.getElementById("burgerBtn").classList.toggle("open");
}
document.querySelectorAll("nav a").forEach(a => a.addEventListener("click", () => {
    document.getElementById("mainNav").classList.remove("open");
    document.getElementById("burgerBtn").classList.remove("open");
}));