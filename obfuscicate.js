require('dotenv').config();
const fs = require('fs-extra');
const path = require('path');
const gulp = require('gulp');
const javascriptObfuscator = require('gulp-javascript-obfuscator');
const sourcemaps = require('gulp-sourcemaps'); 
const minimist = require('minimist'); 
const { setTimeout } = require('timers/promises');

class OBFUSCICATOR {
    constructor(srcDirectoryPath, destDirectoryPath, run_safe=true, preserve_original_on_directory='original_js_asset_folder') {
        this.srcDirectoryPath = srcDirectoryPath;
        this.destDirectoryPath = destDirectoryPath;
        this.run_safe = run_safe;
        this.preserve_original_on_directory = preserve_original_on_directory;
    }

    obfuscicate_func(srcFilePath, destFilePath) {
        gulp.src(srcFilePath)
            .pipe(javascriptObfuscator({
                compact: true,
                controlFlowFlattening: true,
                controlFlowFlatteningThreshold: 0.6,
                deadCodeInjection: true,
                deadCodeInjectionThreshold: 0.8,
                debugProtection: true,
                debugProtectionInterval: 2540,
                disableConsoleOutput: true,
                domainLock: [
                    'http://localhost',
                    'http://127.0.0.1',  
                    'http://192.168.100.127',  
                    'http://192.168.100.127:8200', 
                    'https://hustle.yohpal.com',
                    'https://www.hustle.yohpal.com' 
                ],
                domainLockRedirectUrl: 'https://hustle.yohpal.com',
                identifierNamesGenerator: 'hexadecimal',
                numbersToExpressions: true,
                optionsPreset: 'high-obfuscation',
                renameGlobals: false,
                renameProperties: false,
                selfDefending: true,
                simplify: true,
                seed: 4,
                stringArray: true,
                stringArrayCallsTransform: true,
                stringArrayCallsTransformThreshold: 0.8,
                stringArrayEncoding: [],
                stringArrayIndexesType: ['hexadecimal-numeric-string', 'hexadecimal-number'],
                stringArrayIndexShift: true,
                stringArrayRotate: true,
                stringArrayShuffle: true,
                stringArrayWrappersCount: 12,
                stringArrayWrappersChainedCalls: true,
                stringArrayWrappersParametersMaxCount: 3,
                stringArrayWrappersType: 'variable',
                stringArrayThreshold: 0.85,
                target: 'browser',
                transformObjectKeys: true,
                unicodeEscapeSequence: false
            }))
            .pipe(gulp.dest(destFilePath));
    }

    async renameDirectories(srcPath, destPath) {
        const tempPath = path.join(path.dirname(srcPath), '__temp__');
        
        // Rename src directory to a temporary name
        await fs.move(srcPath, tempPath);

        // Rename dest directory to src directory name
        await fs.move(destPath, srcPath);

        // Rename temp directory to dest directory name
        await fs.move(tempPath, destPath);
    }

    async doesFileExist(filePath) {
        try {
            await fs.promises.access(filePath, fs.constants.F_OK);
            return true;  // File exists
        } catch (err) {
            return false; // File doesn't exist
        }
    }

    async copyFolderRecursive(source, target) {
        
        // Create the target directory if it doesn't exist
        if (!fs.existsSync(target)) {
            fs.mkdirSync(target);
        }
        
        // Get all items in the source directory
        const items = fs.readdirSync(source);
        
        items.forEach(item => {
            const sourcePath = path.join(source, item);
            const targetPath = path.join(target, item);
        
            // Check if the item is a directory
            if (fs.lstatSync(sourcePath).isDirectory()) {
                this.copyFolderRecursive(sourcePath, targetPath);
            } else {
                // Copy the file to the target directory
                fs.copyFileSync(sourcePath, targetPath);
            }
        });
    }
    
    async processFiles(srcPath, destPath) {
        if (this.run_safe == true) {
            // await this.copyFolderRecursive(srcPath, this.preserve_original_on_directory)
        }

        async function traverse(currentPath) {
            const dirItems = await fs.readdir(currentPath);

            for (const item of dirItems) {
                const itemPath = path.join(currentPath, item);
                const stats = await fs.stat(itemPath);

                if (stats.isFile()) {
                    if (itemPath.endsWith('.js')) {   
                        // console.log('JavaScript file:', itemPath); 
                        if (item.includes('vendor.js') ||
                            item.includes('init.js') || 
                            item.includes('icons.min.js') ||
                            item.includes('jquery.min.js') || 
                            item.includes('jquery-ui.min.js') || 
                            item.includes('jquery.js') ||
                            item.includes('jquery-ui.js') || 
                            item.includes('.DS_Store')) { 
                            if (!item.includes('obfuscicated.md') || !item.includes('.DS_Store')) {
                                const relativePath = path.relative(srcPath, itemPath);
                                const destFilePath = path.join(destPath, relativePath);
                                await fs.ensureDir(path.dirname(destFilePath));
                                await fs.copyFile(itemPath, destFilePath);
                            }
                        }
                        else {
                            var obfuscicationDestPath = path.dirname(itemPath);
                            obfuscicationDestPath = obfuscicationDestPath.replace("/js", "/orig.js");
                            console.log('Destination path:', obfuscicationDestPath); 
                            
                            (new OBFUSCICATOR()).obfuscicate_func(itemPath, obfuscicationDestPath); 
                        }
                    } else { 
                        if (!item.includes('obfuscicated.md') || !item.includes('.DS_Store')) {
                            const relativePath = path.relative(srcPath, itemPath);
                            const destFilePath = path.join(destPath, relativePath);
                            await fs.ensureDir(path.dirname(destFilePath));
                            await fs.copyFile(itemPath, destFilePath);
                        }
                    }
                } else if (stats.isDirectory()) {
                    const relativePath = path.relative(srcPath, itemPath);
                    const destDir = path.join(destPath, relativePath);
                    await fs.ensureDir(destDir);
                    await traverse(itemPath);
                } 
            }
        }

        await traverse(srcPath);
    }
    
    overwriteEnvironmentVariable() {
        const fs = require('fs');

        const filePath = '.env';
        const specifiedVariable = 'JS_OBFUSCICATION_RUN';
        var newValue = undefined;

        if (process.env.JS_OBFUSCICATION_RUN.toLocaleLowerCase() == 'true') {
            newValue = 'false';
        }
        else {
            newValue = 'true';
        }

        // Read the content of the environment variable file
        fs.readFile(filePath, 'utf8', (err, data) => {
        if (err) {
            console.error('Error reading the file:', err);
            return;
        }

        // Parse the content to extract environment variables
        const lines = data.split('\n');
        const updatedContent = lines
            .map(line => {
                const [key, value] = line.split('=');

                if (key === specifiedVariable) {
                    return `${key}=${newValue}`;
                }

                return line;
            })
            .join('\n');

            // Write the updated content back to the file
            fs.writeFile(filePath, updatedContent, 'utf8', err => {
                if (err) {
                    console.error('Error writing to the file:', err);
                    return;
                }
                console.log('Environment variable updated successfully.'); 
            });
        }); 
    }

    initObfuscication(srcDirectoryPath, destDirectoryPath) {
        this.processFiles(srcDirectoryPath, destDirectoryPath)
            .then(() => {
                (new OBFUSCICATOR()).renameDirectories(srcDirectoryPath, destDirectoryPath);
            }).then(() => {
                console.log('Directories renamed successfully!');
            }).then(() => {
                (new OBFUSCICATOR()).overwriteEnvironmentVariable();
            })
            .catch((error) => console.error('Error:', error));
    }

    main() { 
        const args = minimist(process.argv.slice(2));
        
        if (process.env.JS_OBFUSCICATION_RUN.toLocaleLowerCase() == 'false') { 
            /****
             * If JS_OBFUSCICATION_RUN variable is set to false, 
             *  run/re-run obfuscaction
             */
            if (args['o'] == 'false') {
                (new OBFUSCICATOR()).renameDirectories(srcDirectoryPath, destDirectoryPath).then(() => {
                    console.log('Directories renamed/reverted successfully!');  
                });

                (new OBFUSCICATOR()).overwriteEnvironmentVariable();
            } 
            
            if (args['o'] == undefined) {
                this.initObfuscication(this.srcDirectoryPath, this.destDirectoryPath);
            }
        }
        else {
            /****
             * If JS_OBFUSCICATION_RUN variable is set to true, 
             *  Revert directories and re-run obfuscaction
             */
            this.renameDirectories(this.destDirectoryPath, this.srcDirectoryPath)
                .then(() => {
                    console.log('Directories renamed/reverted successfully!');  
                }).then(() => { 
                    if (args['o'] == 'false') { 
                        (new OBFUSCICATOR()).overwriteEnvironmentVariable(); 
                    }  
                }).then(() => {
                    if (args['o'] == undefined) {
                        this.initObfuscication(this.srcDirectoryPath, this.destDirectoryPath);
                    } 
                }).catch((error) => console.error('Error:', error));
        } 
    }
}

const srcDirectoryPath = 'assets/js';  // Replace with the source directory path
const destDirectoryPath = 'assets/orig.js';  // Replace with the destination directory path

const obfuscicator = new OBFUSCICATOR(srcDirectoryPath, destDirectoryPath, run_safe=true, preserve_original_on_directory='backup/original_js');
obfuscicator.main();