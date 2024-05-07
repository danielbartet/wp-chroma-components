import { createStore } from 'redux';
import merge from 'lodash/merge';

// Estado inicial
export var initState = {
  questions: [],
  count: 1,
  currentSlide: 0,
  previousSlide: 0,
  nextSlide: 0,
  slideLength: 0,  // Valor inicializado en 0
  currentProgress: 0
};

// Acción de actualización del slideLength basada en el DOM
export function updateSlideLength() {
  initState.slideLength = document.getElementsByClassName('cm-quiz-slide').length;
}

// Reducer
export function questionTracker(state = initState, action) {
  switch (action.type) {
    case 'ADD_QUESTION':
      return {
        ...state,
        questions: [
          ...state.questions,
          {
            index: action.question.index,
            title: action.question.title,
            answer: action.question.answer,
            correct: action.question.correct
          }
        ]
      };
    default:
      return state;
  }
}

// Crear la tienda con Redux
export var cmQuizStore = createStore(questionTracker);

// Función render para prueba o desarrollo
export function render() {
  var renderState = cmQuizStore.getState();
  console.log(renderState); // Asegúrate de usar console.log solo para depuración
}

// Llamar a updateSlideLength después de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', updateSlideLength);
