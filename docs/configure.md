# 4get configuation options

Welcome! This guide assumes that you have a working 4get instance. This will help you configure your instance to the best it can be!

# Files location
1. The main configuration file is located at `data/config.php`
2. The proxies are located in `data/proxies/*.txt`
3. The captcha imagesets are located in `data/captcha/your_image_set/*.png`
4. The captcha font is located in `data/fonts/captcha.ttf`

# Cloudflare bypass (TLS check)
>These instructions have been updated to work with Debian 13 Trixie.

**Note: this only allows you to bypass the browser integrity checks. Captchas & javascript challenges will not be bypassed by this program!**

Configuring this lets you fetch images sitting behind Cloudflare and allows you to scrape the **Yep** search engine.

To come up with this set of instructions, I used [this guide](https://github.com/lwthiker/curl-impersonate/blob/main/INSTALL.md#native-build) as a reference, but trust me you probably want to stick to what's written on this page.

First, compile curl-impersonate (the firefox flavor).
```sh
git clone https://github.com/lwthiker/curl-impersonate/
cd curl-impersonate
sudo apt install build-essential pkg-config cmake ninja-build curl autoconf automake libtool python3-pip libnss3
mkdir build
cd build
../configure
make firefox-build
sudo make firefox-install
sudo ldconfig
```

Once you did this, you should be able to run the following inside your terminal:
```sh
$ curl_ff117 --version
curl 8.1.1 (x86_64-pc-linux-gnu) libcurl/8.1.1 NSS/3.92 zlib/1.2.13 brotli/1.0.9 zstd/1.5.4 libidn2/2.3.3 nghttp2/1.56.0
Release-Date: 2023-05-23
Protocols: dict file ftp ftps gopher gophers http https imap imaps mqtt pop3 pop3s rtsp smb smbs smtp smtps telnet tftp ws wss
Features: alt-svc AsynchDNS brotli HSTS HTTP2 HTTPS-proxy IDN IPv6 Largefile libz NTLM NTLM_WB SSL threadsafe UnixSockets zstd
```

Now, after compiling, you should have a `libcurl-impersonate-ff.so` sitting somewhere. Mine is located at `/usr/local/lib/libcurl-impersonate-ff.so`. Do some patch fuckery:

```sh
sudo su
LD_PRELOAD=/usr/local/lib/libcurl-impersonate-ff.so
CURL_IMPERSONATE=firefox117
patchelf --set-soname libcurl.so.4 /usr/local/lib/libcurl-impersonate-ff.so
ldconfig
```

From here, you will have a broken curl:
```sh
root@fuckedmachine:/# curl --version
curl: /usr/local/lib/libcurl.so.4: no version information available (required by curl)
curl: symbol lookup error: curl: undefined symbol: curl_global_trace, version CURL_OPENSSL_4
```

Which sucks balls, but you should be able to run this:
```
root@fuckedmachine:/# php -r 'print_r(curl_version());' | grep ssl_version
    [ssl_version_number] => 0
    [ssl_version] => NSS/3.92
```

It's very hacky, yes thank you for noticing. There's also the option of using the [forked project](https://github.com/lexiforest/curl-impersonate), but that garbage doesn't support NSS. I'm kind of against impersonating chrome cause you never know when Google is gonna add more fingerprinting bullshit.

If you want a functioning `curl` command line utility again, you can do the following hack:

```
sudo apt remove curl
sudo ln -s /usr/local/bin/curl-impersonate-ff /usr/bin/curl
```

# Robots.txt
Make sure you configure this right to optimize your search engine presence! Head over to `/robots.txt` and change the 4get.ca domain to your own domain.

# Server listing
To be listed on https://4get.ca/instances , you must contact *any* of the people in the server list and ask them to add you to their list of instances in their configuration. The instance list is distributed, and I don't have control over it.

If you see spammy entries in your instances list, simply remove the instance from your list that pushes the offending entries.

# Proxies
4get supports rotating proxies for scrapers! Configuring one is really easy.

1. Head over to the **proxies** folder. Give it any name you want, like `myproxy`, but make sure it has the `txt` extension.
2. Add your proxies to the file. Examples:
	```conf
	# format -> <protocol>:<address>:<port>:<username>:<password>
	# protocol list:
	# raw_ip, http, https, socks4, socks5, socks4a, socks5_hostname
	socks5:1.1.1.1:juicy:cloaca00
	http:1.3.3.7::
	raw_ip::::
	```
3. Go to the **main configuration file**. Then, find which website you want to setup a proxy for.
4. Modify the value `false` with `"myproxy"`, with quotes included and the semicolon at the end.

Done! The scraper you chose should now be using the rotating proxies. When asking for the next page of results, it will use the same proxy to avoid detection!

## Important!
If you ever test out a `socks5` proxy locally on your machine and find out it works but doesn't on your server, try supplying the `socks5_hostname` protocol instead. Hopefully this tip can save you 3 hours of your life!
