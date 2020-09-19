
const setUsuarioLogado = (context, usuario) => {
  context.commit('SET_USUARIO_LOGADO', usuario)
}

const setSaldo = (context, saldo) => {
  context.commit('SET_SALDO', saldo)
}

export {
  setUsuarioLogado,
  setSaldo
}
