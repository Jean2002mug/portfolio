"use strict";
// Free, browser-only semantic ranking: no model prompts sent to paid inference APIs.
// First use downloads Transformers.js and a public sentence-embedding model.

const PROJECTS = [
  {
    title: 'Sightreading App', kind: 'Desktop application',
    description: 'A collaborative Java and JavaFX desktop application for musical sight reading. Includes MIDI keyboard input, generated exercises, feedback, debugging and JUnit tests.',
    details: 'Java, JavaFX, object oriented programming, MIDI, music education, unit testing, JUnit, desktop interface, Git',
    skills: ['Java', 'JavaFX', 'MIDI', 'JUnit', 'Desktop UI'],
    url: 'https://github.com/Jean2002mug/Sightreading-app',
    terms: { Java: ['java', 'object oriented'], JavaFX: ['javafx', 'gui', 'user interface', 'desktop'], MIDI: ['midi', 'music', 'musician'], JUnit: ['junit', 'testing', 'automated test', 'unit test'] },
  },
  {
    title: 'Gravity Calculator', kind: 'Scientific software',
    description: 'Physics and astronomy software begun in 2023, with gravitational force, acceleration, escape velocity and energy calculations in Python and FastAPI, plus a Node.js application API.',
    details: 'Python, FastAPI, Node.js, scientific computing, astronomy, physics, gravitation, REST API, mathematics, software architecture',
    skills: ['Python', 'FastAPI', 'Node.js', 'Astronomy', 'REST API'],
    url: 'projects.php',
    terms: { Python: ['python'], FastAPI: ['fastapi', 'rest api', 'api', 'backend'], 'Node.js': ['node', 'javascript'], Astronomy: ['astronomy', 'celestial', 'space', 'physics', 'scientific', 'gravity'], Mathematics: ['math', 'simulation', 'calculations'] },
  },
  {
    title: 'CSV Parser in C', kind: 'Systems programming',
    description: 'A CSV parser written in C for reading, parsing and writing structured records with file I/O, manual memory management and error handling.',
    details: 'C programming, CSV file parser, low level systems, memory management, pointers, file input and output, error handling',
    skills: ['C', 'File I/O', 'Parsing', 'Memory management'],
    url: 'https://github.com/Jean2002mug/csv-parser-c',
    terms: { C: ['c language', 'c programming', 'systems programming', 'low level'], Parsing: ['parser', 'parsing', 'csv', 'data format'], 'File I/O': ['file', 'read', 'write', 'input output'], 'Memory management': ['memory', 'pointers'] },
  },
  {
    title: 'Authors and Book Publisher Data', kind: 'Data analysis',
    description: 'A Python data analysis project studying book and publisher data using Pandas and Matplotlib for exploratory analysis and data visualization.',
    details: 'Python, Pandas, Matplotlib, data science, analysis, graphs, data visualization, data cleaning, book publishing',
    skills: ['Python', 'Pandas', 'Matplotlib', 'Data analysis'],
    url: 'https://github.com/Jean2002mug/Data-science-final-project',
    terms: { Python: ['python'], Pandas: ['pandas', 'dataframe', 'data processing'], Matplotlib: ['matplotlib', 'visualization', 'chart', 'graph'], 'Data analysis': ['data', 'analytics', 'analysis', 'statistics'] },
  },
  {
    title: 'Attendify — Junior Software Developer', kind: 'Professional experience',
    description: 'Junior Software Developer experience contributing to childcare SaaS features, PHP and CodeIgniter development, SQL investigation, debugging, testing, and stakeholder support.',
    details: 'PHP, CodeIgniter, SQL, MySQL, MariaDB, database queries, web application, debugging, testing, GitLab, developer collaboration',
    skills: ['PHP', 'CodeIgniter', 'SQL', 'Debugging', 'GitLab'],
    url: 'about.php',
    terms: { PHP: ['php', 'backend', 'web app'], CodeIgniter: ['codeigniter', 'framework'], SQL: ['sql', 'mysql', 'mariadb', 'database'], Debugging: ['debug', 'bugs', 'troubleshooting', 'testing'], GitLab: ['gitlab', 'git', 'version control'] },
  },
];

const form = document.getElementById('ai-form');
const questionInput = document.getElementById('ai-question');
const submitButton = document.getElementById('ai-submit');
const basicButton = document.getElementById('ai-basic');
const statusElement = document.getElementById('ai-status');
const resultsElement = document.getElementById('ai-result');
const resultsGrid = document.getElementById('ai-results-grid');
const methodElement = document.getElementById('ai-method');
const hint = document.getElementById('ai-hint');
let modelPromise = null;

const normalize = value => value.toLowerCase().replace(/[-_/]/g, ' ').replace(/\s+/g, ' ').trim();

function matchingSkills(query, project) {
  const text = normalize(query);
  return Object.entries(project.terms)
    .filter(([, synonyms]) => synonyms.some(word => {
      const escaped = normalize(word).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
      return new RegExp(`(^|[^a-z0-9])${escaped}($|[^a-z0-9])`, 'i').test(text);
    }))
    .map(([skill]) => skill);
}

function keywordRank(query) {
  return PROJECTS.map((project, index) => ({
    project, index, matched: matchingSkills(query, project),
  })).sort((a, b) => b.matched.length - a.matched.length || a.index - b.index);
}

function chunkQuestion(input) {
  const clean = input.replace(/\s+/g, ' ').trim();
  // Keep both beginning and end of longer job ads to avoid dropping the skills section.
  if (clean.length <= 1050) return [clean];
  return [clean.slice(0, 950), clean.slice(-950)];
}

function dot(a, b) {
  if (!a || !b || a.length !== b.length) throw new Error('Unexpected model output.');
  let total = 0;
  for (let i = 0; i < a.length; i++) total += a[i] * b[i];
  return total;
}

async function loadModel() {
  if (!modelPromise) {
    modelPromise = (async () => {
      statusElement.textContent = 'Downloading the free AI model for local matching. First use may take a minute…';
      // Pin the published package version for stable behavior, load only on user action.
      const { pipeline, env } = await import('https://cdn.jsdelivr.net/npm/@huggingface/transformers@3.8.1');
      env.allowLocalModels = false;
      return pipeline('feature-extraction', 'Xenova/all-MiniLM-L6-v2', {
        dtype: 'q8',
        progress_callback: event => {
          if (event.status === 'progress' && Number.isFinite(event.progress)) {
            statusElement.textContent = `Downloading free model files… ${Math.round(event.progress)}% of current file`;
          }
        },
      });
    })();
  }
  try { return await modelPromise; }
  catch (error) { modelPromise = null; throw error; }
}

async function semanticRank(query) {
  const extractor = await loadModel();
  statusElement.textContent = 'Comparing your request with the portfolio projects locally…';
  const chunks = chunkQuestion(query);
  const descriptions = PROJECTS.map(p => `${p.title}. ${p.description} ${p.details}`);
  const vectors = (await extractor([...chunks, ...descriptions], { pooling: 'mean', normalize: true })).tolist();
  if (!Array.isArray(vectors) || vectors.length !== chunks.length + PROJECTS.length) {
    throw new Error('Unexpected model output.');
  }
  return PROJECTS.map((project, index) => {
    const vector = vectors[chunks.length + index];
    const similarity = Math.max(...vectors.slice(0, chunks.length).map(q => dot(q, vector)));
    const matched = matchingSkills(query, project);
    // Small exact-skill bonus keeps clear requirements from being lost in a long job posting.
    return { project, index, matched, score: similarity + Math.min(matched.length, 4) * 0.045 };
  }).sort((a, b) => b.score - a.score || a.index - b.index);
}

function renderCard(item, rank) {
  const { project, matched } = item;
  const card = document.createElement('article');
  card.className = 'ai-match-card';
  const top = document.createElement('div');
  top.className = 'ai-match-top';
  const rankLabel = document.createElement('span');
  rankLabel.className = 'ai-rank';
  rankLabel.textContent = rank === 1 ? 'Closest match' : `Match ${rank}`;
  const kind = document.createElement('span');
  kind.className = 'ai-kind';
  kind.textContent = project.kind;
  top.append(rankLabel, kind);

  const title = document.createElement('h3');
  title.textContent = project.title;
  const description = document.createElement('p');
  description.textContent = project.description;
  const skillList = document.createElement('div');
  skillList.className = 'ai-match-skills';
  const visibleSkills = matched.length ? matched.slice(0, 4) : project.skills.slice(0, 3);
  for (const skill of visibleSkills) {
    const chip = document.createElement('span');
    chip.textContent = skill;
    skillList.append(chip);
  }
  const link = document.createElement('a');
  link.href = project.url;
  link.textContent = project.url.endsWith('.php') ? 'View portfolio details ↗' : 'View code on GitHub ↗';
  if (project.url.startsWith('https://')) { link.target = '_blank'; link.rel = 'noopener noreferrer'; }
  card.append(top, title, description, skillList, link);
  return card;
}

function showResults(ranked, mode) {
  resultsGrid.replaceChildren();
  const visible = mode === 'ai' ? ranked.slice(0, 3) : ranked.filter(item => item.matched.length).slice(0, 3);
  // With no keyword overlap, suggest nothing rather than falsely imply a strong match.
  if (!visible.length) {
    const note = document.createElement('p');
    note.textContent = 'No clear keyword overlap was found. Try a more specific skill or use the AI matcher when the model is available.';
    resultsGrid.append(note);
  }
  visible.forEach((item, index) => resultsGrid.append(renderCard(item, index + 1)));
  resultsElement.hidden = false;
  methodElement.textContent = mode === 'ai'
    ? 'Ranked using on-device AI embeddings plus exact skill matches.'
    : mode === 'quick'
    ? 'Quick keyword matching only — no AI model was used.'
    : 'Basic keyword matching only — the AI model could not load.';
}

for (const button of document.querySelectorAll('.ai-example')) {
  button.addEventListener('click', () => {
    const radio = form.querySelector(`input[name="mode"][value="${button.dataset.mode}"]`);
    if (radio) radio.checked = true;
    questionInput.value = button.dataset.question || '';
    questionInput.focus();
  });
}
for (const radio of form.querySelectorAll('input[name="mode"]')) {
  radio.addEventListener('change', () => {
    questionInput.placeholder = radio.value === 'match' && radio.checked
      ? 'Paste the relevant requirements from a job posting (remove personal or confidential details).'
      : 'e.g. I am interested in scientific Python, Java applications and data analysis.';
  });
}

basicButton.addEventListener('click', () => {
  const query = questionInput.value.trim();
  if (query.length < 8) { questionInput.focus(); return; }
  const ranked = keywordRank(query);
  showResults(ranked, 'quick');
  statusElement.textContent = 'Quick keyword matching complete. This mode does not use AI.';
  hint.textContent = 'No model download needed for this mode.';
  resultsElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
});

form.addEventListener('submit', async event => {
  event.preventDefault();
  const query = questionInput.value.trim();
  if (query.length < 8) { questionInput.focus(); return; }
  submitButton.disabled = true;
  submitButton.textContent = 'Finding projects…';
  resultsElement.hidden = true;
  let semanticUsed = false;
  let ranked;
  try {
    ranked = await semanticRank(query);
    semanticUsed = true;
    statusElement.textContent = 'Matching complete. Results were calculated in your browser.';
    hint.textContent = 'Your text was processed locally, not sent to an AI inference service.';
  } catch (error) {
    console.warn('Local AI model unavailable; using keyword matching.', error);
    ranked = keywordRank(query);
    statusElement.textContent = 'The AI model could not load. Showing basic keyword matches instead. Check your internet connection and try again.';
    hint.textContent = 'Keyword matching is not AI inference. Reload and retry for semantic matching.';
  } finally {
    submitButton.disabled = false;
    submitButton.textContent = 'Find matching projects ↗';
  }
  showResults(ranked, semanticUsed ? 'ai' : 'fallback');
  resultsElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
});
