/**
 * Device Info Service
 * Detects and provides comprehensive device information
 */

class DeviceInfoService {
    constructor() {
        this.deviceInfo = null;
        this.init();
    }

    init() {
        this.deviceInfo = {
            userAgent: navigator.userAgent,
            platform: navigator.platform,
            language: navigator.language,
            online: navigator.onLine,
            cookieEnabled: navigator.cookieEnabled,
            deviceMemory: navigator.deviceMemory || 'unknown',
            hardwareConcurrency: navigator.hardwareConcurrency || 'unknown',
            maxTouchPoints: navigator.maxTouchPoints || 0,
            vendor: navigator.vendor,
            screen: {
                width: window.screen.width,
                height: window.screen.height,
                availWidth: window.screen.availWidth,
                availHeight: window.screen.availHeight,
                colorDepth: window.screen.colorDepth,
                pixelDepth: window.screen.pixelDepth,
                orientation: window.screen.orientation?.type || 'unknown'
            },
            viewport: {
                width: window.innerWidth,
                height: window.innerHeight
            },
            deviceType: this.detectDeviceType(),
            browser: this.detectBrowser(),
            os: this.detectOS(),
            isMobile: this.isMobileDevice(),
            isTablet: this.isTabletDevice(),
            isDesktop: this.isDesktopDevice(),
            hasGeolocation: 'geolocation' in navigator,
            hasCamera: false,
            hasMicrophone: false,
            timestamp: Date.now()
        };
        
        this.detectMediaDevices();
    }

    detectDeviceType() {
        const ua = navigator.userAgent.toLowerCase();
        
        if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
            return 'tablet';
        }
        if (/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
            return 'mobile';
        }
        return 'desktop';
    }

    detectBrowser() {
        const ua = navigator.userAgent;
        
        if (ua.indexOf('Firefox') > -1) return 'Firefox';
        if (ua.indexOf('Opera') > -1 || ua.indexOf('OPR') > -1) return 'Opera';
        if (ua.indexOf('Trident') > -1) return 'IE';
        if (ua.indexOf('Edge') > -1) return 'Edge';
        if (ua.indexOf('Chrome') > -1) return 'Chrome';
        if (ua.indexOf('Safari') > -1) return 'Safari';
        
        return 'Unknown';
    }

    detectOS() {
        const ua = navigator.userAgent;
        const platform = navigator.platform;
        
        if (/Win/i.test(platform)) return 'Windows';
        if (/Mac/i.test(platform)) return 'MacOS';
        if (/Linux/i.test(platform)) return 'Linux';
        if (/iPhone|iPad|iPod/.test(ua)) return 'iOS';
        if (/Android/.test(ua)) return 'Android';
        
        return 'Unknown';
    }

    isMobileDevice() {
        return this.deviceInfo?.deviceType === 'mobile';
    }

    isTabletDevice() {
        return this.deviceInfo?.deviceType === 'tablet';
    }

    isDesktopDevice() {
        return this.deviceInfo?.deviceType === 'desktop';
    }

    async detectMediaDevices() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
            return;
        }
        
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            this.deviceInfo.hasCamera = devices.some(device => device.kind === 'videoinput');
            this.deviceInfo.hasMicrophone = devices.some(device => device.kind === 'audioinput');
        } catch (error) {
            console.error('Error detecting media devices:', error);
        }
    }

    async getLocationCapabilities() {
        if (!navigator.geolocation) {
            return {
                supported: false,
                permission: 'denied',
                accuracy: null
            };
        }
        
        let permission = 'unknown';
        try {
            const permissionStatus = await navigator.permissions.query({ name: 'geolocation' });
            permission = permissionStatus.state;
        } catch (e) {
            permission = 'prompt';
        }
        
        return {
            supported: true,
            permission: permission,
            highAccuracySupported: true
        };
    }

    async getBatteryInfo() {
        if (!navigator.getBattery) {
            return { supported: false };
        }
        
        try {
            const battery = await navigator.getBattery();
            return {
                supported: true,
                level: battery.level,
                charging: battery.charging,
                chargingTime: battery.chargingTime,
                dischargingTime: battery.dischargingTime
            };
        } catch (error) {
            return { supported: false };
        }
    }

    async getNetworkInfo() {
        const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
        
        if (!connection) {
            return {
                supported: false,
                online: navigator.onLine
            };
        }
        
        return {
            supported: true,
            online: navigator.onLine,
            effectiveType: connection.effectiveType,
            downlink: connection.downlink,
            rtt: connection.rtt,
            saveData: connection.saveData
        };
    }

    getDeviceInfo() {
        return { ...this.deviceInfo };
    }

    async getFullDeviceReport() {
        const locationCaps = await this.getLocationCapabilities();
        const battery = await this.getBatteryInfo();
        const network = await this.getNetworkInfo();
        
        return {
            ...this.deviceInfo,
            location: locationCaps,
            battery: battery,
            network: network,
            timestamp: Date.now()
        };
    }

    logDeviceInfo() {
        console.group('Device Information');
        console.log('Device Type:', this.deviceInfo.deviceType);
        console.log('Browser:', this.deviceInfo.browser);
        console.log('OS:', this.deviceInfo.os);
        console.log('Screen:', this.deviceInfo.screen);
        console.log('Viewport:', this.deviceInfo.viewport);
        console.log('Has Geolocation:', this.deviceInfo.hasGeolocation);
        console.log('Has Camera:', this.deviceInfo.hasCamera);
        console.log('Has Microphone:', this.deviceInfo.hasMicrophone);
        console.groupEnd();
    }
}

// Export
window.DeviceInfoService = DeviceInfoService;
