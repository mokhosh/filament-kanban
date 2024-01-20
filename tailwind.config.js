const preset = require('./vendor/filament/filament/tailwind.config.preset')

module.exports = {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            animation: {
                'pulse-twice': 'pulse 1s cubic-bezier(0, 0, 0.2, 1) 2',
            }
        }
    }
}
