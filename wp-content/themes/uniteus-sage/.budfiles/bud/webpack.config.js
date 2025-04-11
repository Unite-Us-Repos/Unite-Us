module.exports = {
  "bail": true,
  "cache": {
    "name": "bud.production",
    "type": "filesystem",
    "version": "hqguptmliduzb27hdtbnobonqoa_",
    "cacheDirectory": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/.budfiles/cache/webpack",
    "managedPaths": [
      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules"
      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules"
    ],
    "buildDependencies": {
      "bud": [
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/package.json",
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/.editorconfig",
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/.yarnrc.yml",
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/bud.config.js",
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/composer.json",
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/jsconfig.json",
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/tailwind.config.js",
        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/theme.json"
      ]
    }
  },
  "context": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage",
  "context": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage",
  "infrastructureLogging": {
    "console": {
      "Console": {}
    }
  },
  "mode": "production",
  "module": {
    "noParse": {},
    "rules": [
      {
        "test": {},
        "include": [
          "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
          "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
        ],
        "parser": {
          "requireEnsure": false
        }
      },
      {
        "oneOf": [
          {
            "test": {},
            "use": [
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/babel-loader/lib/index.js",
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/babel-loader/lib/index.js",
                "options": {
                  "presets": [
                    [
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/preset-env/lib/index.js"
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/preset-env/lib/index.js"
                    ],
                    [
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/preset-react/lib/index.js"
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/preset-react/lib/index.js"
                    ]
                  ],
                  "plugins": [
                    [
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-transform-runtime/lib/index.js",
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-transform-runtime/lib/index.js",
                      {
                        "helpers": false
                      }
                    ],
                    [
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-proposal-object-rest-spread/lib/index.js"
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-proposal-object-rest-spread/lib/index.js"
                    ],
                    [
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-syntax-dynamic-import/lib/index.js"
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-syntax-dynamic-import/lib/index.js"
                    ],
                    [
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-proposal-class-properties/lib/index.js"
                      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@babel/plugin-proposal-class-properties/lib/index.js"
                    ]
                  ]
                }
              }
            ],
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ]
          },
          {
            "test": {},
            "use": [
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/mini-css-extract-plugin/dist/loader.js"
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/mini-css-extract-plugin/dist/loader.js"
              },
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/css-loader/dist/cjs.js",
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/css-loader/dist/cjs.js",
                "options": {
                  "importLoaders": 1,
                  "sourceMap": false
                }
              },
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@roots/bud-postcss/node_modules/postcss-loader/dist/cjs.js",
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@roots/bud-postcss/node_modules/postcss-loader/dist/cjs.js",
                "options": {
                  "postcssOptions": {
                    "plugins": [
                      [
                        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@roots/bud-postcss/node_modules/postcss-import/index.js"
                        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@roots/bud-postcss/node_modules/postcss-import/index.js"
                      ],
                      [
                        null
                      ],
                      [
                        null
                      ],
                      [
                        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@roots/bud-postcss/node_modules/postcss-preset-env/dist/index.cjs",
                        "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/@roots/bud-postcss/node_modules/postcss-preset-env/dist/index.cjs",
                        {
                          "stage": 1,
                          "features": {
                            "focus-within-pseudo-class": false
                          }
                        }
                      ]
                    ]
                  },
                  "sourceMap": true
                }
              }
            ],
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ]
          },
          {
            "test": {},
            "use": [
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/mini-css-extract-plugin/dist/loader.js"
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/mini-css-extract-plugin/dist/loader.js"
              },
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/css-loader/dist/cjs.js",
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/css-loader/dist/cjs.js",
                "options": {
                  "importLoaders": 1,
                  "localIdentName": "[name]__[local]___[hash:base64:5]",
                  "modules": true,
                  "sourceMap": false
                }
              }
            ],
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ]
          },
          {
            "test": {},
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ],
            "type": "asset/resource",
            "generator": {
              "filename": "images/[name].[contenthash:6][ext]"
            }
          },
          {
            "test": {},
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ],
            "type": "asset/resource",
            "generator": {
              "filename": "images/[name].[contenthash:6][ext]"
            }
          },
          {
            "test": {},
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ],
            "type": "asset/resource",
            "generator": {
              "filename": "images/[name].[contenthash:6][ext]"
            }
          },
          {
            "test": {},
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ],
            "type": "asset",
            "generator": {
              "filename": "fonts/[name].[contenthash:6][ext]"
            }
          },
          {
            "test": {},
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ],
            "type": "json",
            "parser": {}
          },
          {
            "test": {},
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ],
            "type": "json",
            "parser": {}
          },
          {
            "test": {},
            "use": [
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/html-loader/dist/cjs.js"
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/html-loader/dist/cjs.js"
              }
            ],
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ]
          },
          {
            "test": {},
            "use": [
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/csv-loader/index.js"
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/csv-loader/index.js"
              }
            ],
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ]
          },
          {
            "test": {},
            "use": [
              {
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/xml-loader/index.js"
                "loader": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/node_modules/xml-loader/index.js"
              }
            ],
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ]
          },
          {
            "test": {},
            "include": [
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
              "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources"
            ],
            "type": "json",
            "parser": {}
          }
        ]
      }
    ],
    "unsafeCache": false
  },
  "name": "bud",
  "node": false,
  "output": {
    "assetModuleFilename": "[name].[contenthash:6][ext]",
    "chunkFilename": "[name].[contenthash:6].js",
    "filename": "[name].[contenthash:6].js",
    "path": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/public",
    "path": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/public",
    "pathinfo": false,
    "publicPath": ""
  },
  "optimization": {
    "emitOnErrors": false,
    "minimize": true,
    "minimizer": [
      "...",
      {
        "options": {
          "test": {},
          "parallel": true,
          "minimizer": {
            "options": {
              "preset": [
                "default",
                {
                  "discardComments": {
                    "removeAll": true
                  }
                }
              ]
            }
          }
        }
      }
    ],
    "runtimeChunk": "single",
    "splitChunks": {
      "cacheGroups": {
        "bud": {
          "chunks": "all",
          "test": {},
          "reuseExistingChunk": true,
          "priority": -10
        },
        "vendor": {
          "chunks": "all",
          "test": {},
          "reuseExistingChunk": true,
          "priority": -20
        }
      }
    }
  },
  "parallelism": 7,
  "performance": {
    "hints": false
  },
  "recordsPath": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/.budfiles/bud/modules.json",
  "recordsPath": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/.budfiles/bud/modules.json",
  "stats": "normal",
  "target": "browserslist:/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/package.json",
  "target": "browserslist:/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/package.json",
  "plugins": [
    {
      "patterns": [
        {
          "from": "images/**/*",
          "context": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources",
          "context": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources",
          "noErrorOnMissing": true
        }
      ],
      "options": {}
    },
    {
      "options": {
        "assetHookStage": null,
        "basePath": "",
        "fileName": "manifest.json",
        "filter": null,
        "map": null,
        "publicPath": "",
        "removeKeyHash": {},
        "sort": null,
        "transformExtensions": {},
        "useEntryKeys": false,
        "useLegacyEmit": false,
        "writeToFileEmit": true
      }
    },
    {
      "_sortedModulesCache": {},
      "options": {
        "filename": "[name].[contenthash:6].css",
        "ignoreOrder": false,
        "runtime": true,
        "chunkFilename": "[name].[contenthash:6].css"
      },
      "runtimeOptions": {
        "linkType": "text/css"
      }
    },
    {
      "plugin": {
        "name": "WordPressDependenciesWebpackPlugin",
        "stage": null
      },
      "manifest": {},
      "usedDependencies": {},
      "fileName": "wordpress.json"
    },
    {
      "options": {
        "emitHtml": false,
        "publicPath": ""
      },
      "plugin": {
        "name": "EntrypointsManifestPlugin",
        "stage": null
      },
      "name": "entrypoints.json"
    },
    {
      "plugin": {
        "name": "MergedManifestPlugin"
      },
      "file": "entrypoints.json",
      "entrypointsName": "entrypoints.json",
      "wordpressName": "wordpress.json"
    },
    {
      "name": "WordPressExternalsWebpackPlugin",
      "stage": null,
      "externals": {
        "type": "window"
      }
    },
    {
      "plugin": {
        "name": "MergedManifestPlugin"
      },
      "file": "entrypoints.json",
      "entrypointsName": "entrypoints.json",
      "wordpressName": "wordpress.json"
    }
  ],
  "entry": {
    "app": {
      "import": [
        "@scripts/app",
        "@styles/app"
      ],
      "publicPath": "/wp-content/themes/uniteus-sage/public/"
    },
    "time": {
      "import": [
        "@scripts/time"
      ],
      "publicPath": "/wp-content/themes/uniteus-sage/public/"
    },
    "editor": {
      "import": [
        "@scripts/editor",
        "@styles/editor"
      ]
    }
  },
  "resolve": {
    "alias": {
      "@src": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources",
      "@dist": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/public",
      "@fonts": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/fonts",
      "@images": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/images",
      "@scripts": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/scripts",
      "@styles": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/styles"
      "@src": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources",
      "@dist": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/public",
      "@fonts": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/fonts",
      "@images": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/images",
      "@scripts": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/scripts",
      "@styles": "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources/styles"
    },
    "extensions": [
      ".wasm",
      ".mjs",
      ".js",
      ".jsx",
      ".css",
      ".json",
      ".toml",
      ".yml"
    ],
    "modules": [
      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources",
      "/Users/tamayo/Local Sites/uniteus-dev/app/public/wp-content/themes/uniteus-sage/resources",
      "node_modules"
    ]
  }
}
