fos.Router.setData({"base_url":"","routes":{"home_index":{"tokens":[["text","\/"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_footer":{"tokens":[["text","\/__home\/footer"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_topbar":{"tokens":[["text","\/__home\/topbar"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_ajuda":{"tokens":[["text","\/ajuda"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_cadastre":{"tokens":[["text","\/cadastre"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_cadastre_submeter-email-projeto":{"tokens":[["text","\/cadastre\/submeter-email-projeto"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_comece":{"tokens":[["text","\/comece"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_crowdfunding":{"tokens":[["text","\/crowdfunding"]],"defaults":[],"requirements":[],"hosttokens":[]},"home_termos-uso":{"tokens":[["text","\/termos-uso"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_index":{"tokens":[["text","\/admin"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_gerenciar-administradores":{"tokens":[["text","\/admin\/gerenciar-administradores"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_vincular-usuario-administrador":{"tokens":[["text","\/admin\/vincular-usuario-administrador"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_adicionar-administrador":{"tokens":[["variable","\/","[^\/]++","usuarioId"],["text","\/admin\/adicionar-administrador"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_remover-administrador":{"tokens":[["variable","\/","[^\/]++","usuarioId"],["text","\/admin\/remover-administrador"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_pagamentos":{"tokens":[["text","\/admin\/pagamentos"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_informar-pagamento":{"tokens":[["variable","\/","[^\/]++","projetoId"],["text","\/admin\/informar-pagamento"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_registro-termo-uso":{"tokens":[["text","\/admin\/registro-termo-uso"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_registrar-termo-uso":{"tokens":[["text","\/admin\/registrar-termo-uso"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_categorias":{"tokens":[["text","\/admin\/categorias"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_salvar-categoria":{"tokens":[["text","\/admin\/salvar-categoria"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"admin_lista-aprovacao-submissao":{"tokens":[["text","\/admin\/lista-aprovacao-submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_aprovacao-submissao":{"tokens":[["variable","\/","[^\/]++","submissaoId"],["text","\/admin\/aprovacao-submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_salvar-aprovacao-submissao":{"tokens":[["text","\/admin\/salvar-aprovacao-submissao"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"admin_estornos":{"tokens":[["text","\/admin\/estornos"]],"defaults":[],"requirements":[],"hosttokens":[]},"admin_estornos_projeto":{"tokens":[["variable","\/","[^\/]++","projetoId"],["text","\/admin\/estornos"]],"defaults":[],"requirements":[],"hosttokens":[]},"pagamento_checkout":{"tokens":[["variable","\/","[^\/]++","projetoId"],["text","\/pagamento\/checkout"]],"defaults":[],"requirements":[],"hosttokens":[]},"pagamento_continue-checkout":{"tokens":[["text","\/pagamento\/continue-checkout"]],"defaults":[],"requirements":[],"hosttokens":[]},"pagamento_review":{"tokens":[["text","\/pagamento\/review"]],"defaults":[],"requirements":[],"hosttokens":[]},"pagamento_retorno-pagamento":{"tokens":[["text","\/pagamento\/retorno-pagamento"]],"defaults":[],"requirements":[],"hosttokens":[]},"projeto_salvar-atualizacao":{"tokens":[["text","\/projeto\/salvar-atualizacao"]],"defaults":[],"requirements":[],"hosttokens":[]},"projeto_descubra":{"tokens":[["text","\/descubra"]],"defaults":[],"requirements":{"url":".*\/"},"hosttokens":[]},"projeto_descubra-search":{"tokens":[["variable","\/","[^\/]++","search"],["text","\/descubra"]],"defaults":[],"requirements":[],"hosttokens":[]},"projeto_search":{"tokens":[["variable","\/","[^\/]++","search"],["text","\/projeto\/search"]],"defaults":[],"requirements":[],"hosttokens":[]},"projeto_get-more":{"tokens":[["text","\/projeto\/get-more"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_termo-uso":{"tokens":[["text","\/submissao\/termo-uso"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_iniciar":{"tokens":[["text","\/submissao\/iniciar"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_dados-basicos":{"tokens":[["text","\/dados-basicos"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_salvar-dados-basicos":{"tokens":[["text","\/salvar-dados-basicos"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"submissao_descricao":{"tokens":[["text","\/descricao"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_salvar-descricao":{"tokens":[["variable","\/","[^\/]++","submissaoId"],["text","\/submissao\/salvar-descricao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_recompensas":{"tokens":[["text","\/recompensas"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_salvar-recompensas":{"tokens":[["variable","\/","[^\/]++","submissaoId"],["text","\/submissao\/salvar-recompensas"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_video":{"tokens":[["text","\/video"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_salvar-video":{"tokens":[["text","\/salvarVideo"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"submissao_imagens":{"tokens":[["text","\/imagens"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_salvar-imagem-original":{"tokens":[["text","\/salvar-imagem-original"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_salvar-crop":{"tokens":[["text","\/salvar-crop"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"submissao_get-crop-params":{"tokens":[["text","\/submissao\/getCropParams"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_mais-sobre-voce":{"tokens":[["text","\/mais-sobre-voce"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_salvar-mais-sobre-voce":{"tokens":[["text","\/salvar-mais-sobre-voce"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"submissao_concluir":{"tokens":[["text","\/concluir"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"submissao_sucesso":{"tokens":[["text","\/sucesso"],["variable","\/","[^\/]++","submissaoId"],["text","\/submissao"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_meus-projetos":{"tokens":[["text","\/usuario\/meus-projetos"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_contribuicoes":{"tokens":[["text","\/usuario\/contribuicoes"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_dados-pessoais":{"tokens":[["text","\/usuario\/dados-pessoais"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_alterar-dados-pessoais":{"tokens":[["text","\/usuario\/alterar-dados-pessoais"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_confirmacao-inativar-conta":{"tokens":[["text","\/usuario\/confirmacao-inativar-conta"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_inativar-conta":{"tokens":[["text","\/usuario\/inativar-conta"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_login":{"tokens":[["text","\/usuario\/login"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_registro":{"tokens":[["text","\/usuario\/registro"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_registrar":{"tokens":[["text","\/usuario\/registrar"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_registro-sucesso":{"tokens":[["text","\/usuario\/registro-sucesso"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_esqueci-minha-senha":{"tokens":[["text","\/usuario\/esqueci-minha-senha"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_enviar-esqueci-minha-senha":{"tokens":[["text","\/usuario\/enviar-esqueci-minha-senha"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_evalidar-token-senha":{"tokens":[["variable","\/","[^\/]++","token"],["text","\/usuario\/validar-token-senha"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_cadastro-nova-senha":{"tokens":[["text","\/usuario\/cadastro-nova-senha"]],"defaults":[],"requirements":[],"hosttokens":[]},"usuario_alterar-senha":{"tokens":[["text","\/usuario\/alterar-senha"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"usuario_salvar-imagem-temporaria-profile":{"tokens":[["text","\/usuario\/salvar-imagem-temporaria-profile"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"usuario_recortar-imagem-profile":{"tokens":[["text","\/usuario\/recortar-imagem-profile"]],"defaults":[],"requirements":{"_method":"POST"},"hosttokens":[]},"usuario_apoiadores-projeto":{"tokens":[["variable","\/","[^\/]++","projetoId"],["text","\/usuario\/apoiadores-projeto"]],"defaults":[],"requirements":[],"hosttokens":[]},"login_check":{"tokens":[["text","\/login_check"]],"defaults":[],"requirements":[],"hosttokens":[]},"logout":{"tokens":[["text","\/logout"]],"defaults":[],"requirements":[],"hosttokens":[]},"projeto_visualizar":{"tokens":[["variable","\/","[^\/]++","projetoSlug"]],"defaults":[],"requirements":[],"hosttokens":[]}},"prefix":"","host":"localhost","scheme":"http"});