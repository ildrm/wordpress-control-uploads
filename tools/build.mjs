import { build } from 'esbuild';
await build({entryPoints: ['assets/src/admin.tsx'], outfile: 'assets/js/admin.js', bundle: true, minify: true, target: ['es2020'], jsxFactory: 'h', jsxFragment: 'Fragment', legalComments: 'none'});
