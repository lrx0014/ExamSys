pipeline {
  agent {
    node {
      label 'docker'
    }

  }
  stages {
    stage('build') {
      steps {
        sh '''docker build -t lrx0014/examsys:auto-build .

echo "build finished"'''
      }
    }

    stage('push') {
      steps {
        sh '''docker push lrx0014/examsys:auto-build
echo "push finished"'''
      }
    }

  }
}